<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Reservation;
use stdClass;

class OwnerReservationController extends Controller
{
    //
    public function index() {
        $listings = Listing::where('owner_id', auth()->user()->id)->get();
        $reservations = new stdClass;
        foreach($listings as $ls) {
            //find the rooms of owner and find the rooms in the reservation table,
            $reservations->{$ls->id} = Reservation::where('listing_id', $ls->id)->get();
        }
        return Inertia::render('Owner/Reservations', ['reservations' => $reservations]);
    }
}
