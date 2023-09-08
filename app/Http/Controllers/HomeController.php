<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\GuestHouse;
use App\Models\Reservation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index() {
        return Inertia::render('Guest/Index');
    }

    public function show() {
        return Inertia::render('Guest/Show');
    }

    public function payment(GuestHouse $room) {
        return Inertia::render('ConfirmReservation', ['guesthouse' => $room]);
    }

    public function settings() {
        return Inertia::render('Auth/Settings');
    }

    public function guidelines() {
        return Inertia::render('Guidelines');
    }

    public function rules() {
        return Inertia::render('RulesAndRegulations');
    }

    public function wishlist() {
        return Inertia::render('Wishlist');
    }

    public function about() {
        return Inertia::render('About');
    }

    public function profile(User $user) {
        return Inertia::render('Auth/Profile', ['user' => $user]);
    }

    public function reservations() {
        $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        foreach($reservations as $r) {
            $r->guesthouse = GuestHouse::find($r->room_id);
        }
        return Inertia::render('Reservations', ['reservations' => $reservations]);
    }

    public function map() {
        return Inertia::render('Map/Index', ['guesthouses' => GuestHouse::all()]);
    }

}
