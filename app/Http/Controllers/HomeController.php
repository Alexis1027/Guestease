<?php

namespace App\Http\Controllers;

use App\Models\GuestHouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index() {
        return Inertia::render('GuestHouse/Index');
    }

    public function show() {
        return Inertia::render('GuestHouse/Show');
    }

    public function payment(GuestHouse $room) {
        return Inertia::render('ConfirmReservation', ['guesthouse' => $room]);
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


    public function reservations() {
        return Inertia::render('ViewReservation');
    }

    public function map() {
        return Inertia::render('Map/Index');
    }

}
