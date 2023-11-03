<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index() {
        $listings = Listing::latest()->where('status', 'Available')->get();

        foreach($listings as $gh) {
            $ratings = Rating::where('listing_id', $gh->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $gh->averageRating = number_format($averageRating, 2);
        }

        return Inertia::render('Guest/Index', [
            'listings' => $listings
        ]);
    }

    public function show(Listing $listing) {

        // get all the ratings from the listing
        $ratings = Rating::where('listing_id', $listing->id)
        ->whereIn('user_id', function($query) {
            $query->select('id')->from('users');
        })->get();

        // if $ratings has a value then loop each to get the user
        foreach($ratings as $r) {
            $r->user = User::find($r->user_id);
        }

        // this code gets the average rating
        $totalRatings = count($ratings);
        $sumRatings = $ratings->sum('rating');
        $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
        $averageRating = number_format($averageRating, 2);

        // get all the reserved dates from the listing
        $reservedDates = Reservation::where('listing_id', $listing->id)
            ->select('checkin', 'checkout')
            ->get();

        // get the owner of the listing
        $owner = User::find($listing->owner_id);

        if(auth()->user()) {

            // if logged in, check if the user has rated or wishlisted the listing
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('listing_id', $listing->id)->first();
            $rating = Rating::where('user_id', auth()->user()->id)->where('listing_id', $listing->id)->first();
            
            // if $rating is true then get the user
            if($rating) {
                $rating->user = User::find(auth()->user()->id);
            }

            return Inertia::render('Guest/Show', [
                'listing' => $listing,
                'wishlist' => $wishlist, 
                'rated' => $rating,
                'owner' => $owner,
                'ratings' => $ratings,
                'averageRating' => $averageRating,
                'reservedDates' => $reservedDates
            ]);
        }
        else {

            return Inertia::render('Guest/Show', [
                'listing' => $listing, 
                'owner' => $owner,
                'ratings' => $ratings, 
                'averageRating' => $averageRating,
                'reservedDates' => $reservedDates
            ]);
        }
    }

    public function confirm_reservation(Listing $listing, Request $request) {

        $request->validate([
            'guests' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'days' => 'required',
        ]);

        return Inertia::render('Guest/ConfirmReservation', [
            'listing' => $listing, 
            'guests' => $request->query('guests'),
            'checkin' => $request->query('checkin'),
            'checkout' => $request->query('checkout'),
            'days' => $request->query('days')
        ]);
    }

    public function account() {
        return Inertia::render('Account');
    }

    public function guidelines() {
        return Inertia::render('Guidelines');
    }

    public function rules() {
        return Inertia::render('Admin/RulesAndRegulations');
    }

    public function wishlist() {
        return Inertia::render('Wishlist');
    }

    public function about() {
        return Inertia::render('About');
    }

    public function notifications() {
        return Inertia::render('Guest/Notifications');
    }

    public function contact_us() {
        return Inertia::render('ContactUs');
    }

    public function profile(User $user) {
        $listings =  Listing::where('owner_id', $user->id)->select(['id', 'images', 'title', 'location'])->get();
        return Inertia::render('Profile', ['user' => $user, 'listings' => $listings]);
    }

    public function reservations() {
        $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        foreach($reservations as $r) {
            $r->listing = Listing::find($r->listing_id);
        }
        return Inertia::render('Guest/Reservations', ['reservations' => $reservations]);
    }

    public function map() {
        return Inertia::render('Guest/Map', ['listings' => Listing::all()]);
    }

    public function reservation_history() {
        return Inertia::render('Guest/ReservationHistory');
    }

}
