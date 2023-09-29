<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\GuestHouse;
use App\Models\Reservation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index() {
        $guesthouses = GuestHouse::latest()->get();

        foreach($guesthouses as $gh) {
            $ratings = Rating::where('room_id', $gh->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $gh->averageRating = number_format($averageRating, 2);
        }

        return Inertia::render('Guest/Index', [
            'guesthouses' => $guesthouses
        ]);
    }

    public function show(GuestHouse $id) {
        if(auth()->user()) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)
                ->where('room_id', $id->id)
                ->first();

            $rating = Rating::where('user_id', auth()->user()->id)
            ->where('room_id', $id->id)
            ->first();
            
            if($rating) {
                $rating->user = User::find(auth()->user()->id);
            }

            $ratings = Rating::where('room_id', $id->id)
            ->whereIn('user_id', function($query) {
                $query->select('id')->from('users');
            })
            ->get();

            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $averageRating = number_format($averageRating, 2);
            foreach($ratings as $r) {
                $r->user = User::find($r->user_id);
            }

            $owner = User::find($id->owner_id);

            return Inertia::render('Guest/Show', [
                'guesthouse' => $id,
                'wishlist' => $wishlist, 
                'rated' => $rating,
                'owner' => $owner,
                'ratings' => $ratings,
                'averageRating' => $averageRating
            ]);
            
        }
        else {
            $ratings = Rating::where('room_id', $id->id)
            ->whereIn('user_id', function($query) {
                $query->select('id')->from('users');
            })
            ->get();

            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $averageRating = number_format($averageRating, 2);
            foreach($ratings as $r) {
                $r->user = User::find($r->user_id);
            }
            $owner = User::find($id->owner_id);

            return Inertia::render('Guest/Show', [
                'guesthouse' => $id, 
                'owner' => $owner,
                'ratings' => $ratings, 
                'averageRating' => $averageRating
            ]);
        }
    }

    public function confirm_reservation(GuestHouse $room, Request $request) {

        $request->validate([
            'guests' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'days' => 'required',
        ]);
        
        return Inertia::render('Guest/ConfirmReservation', [
            'guesthouse' => $room, 
            'guests' => $request->query('guests'),
            'checkin' => $request->query('checkin'),
            'checkout' => $request->query('checkout'),
            'days' => $request->query('days')
        ]);
    }

    public function settings() {
        return Inertia::render('Settings');
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

    public function profile(User $user) {
        return Inertia::render('Profile', ['user' => $user]);
    }

    public function reservations() {
        $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        foreach($reservations as $r) {
            $r->guesthouse = GuestHouse::find($r->room_id);
        }
        return Inertia::render('Guest/Reservations', ['reservations' => $reservations]);
    }

    public function map() {
        return Inertia::render('Guest/Map', ['guesthouses' => GuestHouse::all()]);
    }

}
