<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class GuestReservationController extends Controller
{
    //
    public function cancel(Reservation $reservation, Request $request) {
        $reservation->status = 'cancelled';
        $reservation->update();
        return back();
    }
}
