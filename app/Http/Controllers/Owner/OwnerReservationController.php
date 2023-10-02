<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\GuestHouse;
use App\Models\Reservation;
use stdClass;

class OwnerReservationController extends Controller
{
    //
    public function index() {
        $guesthouses = GuestHouse::where('owner_id', auth()->user()->id)->get();
        $reservations = new stdClass;
        foreach($guesthouses as $gh) {
            //find the rooms of owner and find the rooms in the reservation table,
            $reservations->{$gh->id} = Reservation::where('room_id', $gh->id)->get();
        }
        return Inertia::render('Owner/Reservations', ['reservations' => $reservations]);
    }
}
