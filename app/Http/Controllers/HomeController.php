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
    public function rules() {
        return Inertia::render('Admin/RulesAndRegulations');
    }

    public function wishlist() {
        return Inertia::render('Wishlist');
    }

    public function about() {
        return Inertia::render('About');
    }

    public function contact_us() {
        return Inertia::render('ContactUs');
    }

    public function profile(User $user) {
        $listings =  Listing::where('owner_id', $user->id)->where('status', '!=', 'Deleted')->select(['id', 'images', 'title', 'location'])->get();
        return Inertia::render('Profile', ['user' => $user, 'listings' => $listings]);
    }

    public function map() {
        return Inertia::render('Guest/Map', ['listings' => Listing::where('status', '!=', 'Deleted')->get()]);
    }

    public function index() {
        $listings = Listing::latest()->where('status', '!=', 'Deleted')->where('status', '!=', 'Rejected')->get();

        foreach($listings as $ls) {
            $ratings = Rating::where('listing_id', $ls->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $ls->averageRating = number_format($averageRating, 2);
        }
        return Inertia::render('Guest/Index', [
            'listings' => $listings
        ]);
    }

    public function search(Request $request) {

        $request->validate([
            'checkin_date' => 'required',
            'checkout_date' => 'required',
            'people' => 'required'
        ]);

        $checkin = $request->query('checkin_date');
        $checkout = $request->query('checkout_date');
        $people = $request->query('people');
        $type = 'Guest house';
        $type2 = ''; 
        if($request->type !== 'Guest house') {
            $type = 'Room';
            $type2 = 'Multiple room';
        }

        $availableListings = Listing::whereDoesntHave('reservations', function ($query) use ($checkin, $checkout) {
            $query->where(function ($q) use ($checkin, $checkout) {
                $q->where('checkin', '<', $checkout)
                  ->where('checkout', '>', $checkin);
            });
        })->where('guests', '>=', $people)->where('type', $type)->orWhere('type', $type2)->get();

        return Inertia::render('Guest/Search', ['listings' => $availableListings]);
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
            ->where('status', 'approved')
            ->orWhere('status', 'pending')
            ->select('checkin', 'checkout')
            ->get();
        // get the owner of the listing
        $owner = User::find($listing->owner_id);

        if(auth()->user()) {
            $reservationForReview = Reservation::where('user_id', auth()->user()->id)
                ->where('listing_id', $listing->id)
                ->whereIn('status', ['approved', 'completed'])
                ->get();
            $can_review = false;
            if ($reservationForReview->count() > 0 && $reservationForReview[0]->checkin <= now()) {
                $can_review = true;
            }

            $is_reserved = Reservation::where('user_id', auth()->user()->id)
            ->where('listing_id', $listing->id)
            ->where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhere('status', 'pending');
            })
            ->get();
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
                'reservedDates' => $reservedDates,
                'is_reserved' => $is_reserved,
                'can_review' => $can_review
            ]);
        }
        else {

            return Inertia::render('Guest/Show', [
                'listing' => $listing, 
                'owner' => $owner,
                'ratings' => $ratings, 
                'averageRating' => $averageRating,
                'reservedDates' => $reservedDates,
            ]);
        }
    }

    
    
}
