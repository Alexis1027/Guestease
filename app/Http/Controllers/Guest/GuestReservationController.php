<?php

namespace App\Http\Controllers\Guest;

use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestReservationController extends Controller
{
    //
    public function cancel(Reservation $reservation, Request $request) {
        $reservation->status = 'cancelled';
        $reservation->update();
        return back();
    }

    public function store(Listing $listing, Request $request) {
        if(($listing->type == "Room" || $listing->type == "Guest house") && $request->status == "approved") {
            // $listing->status = "Not available"
            $listing->status = 'Not available';
            $listing->update();
        }
        $form = $request->validate([
            'payment_process' => 'required'
        ]);
        $form['days'] = $request->days;
        $form['user_id'] = $request->user_id;
        $form['listing_id'] = $request->listing_id;
        $form['status'] = $request->status;
        $form['checkin'] = $request->checkin;
        $form['checkout'] = $request->checkout;
        $form['guests'] = $request->guests;
        $form['total'] = $request->total;
        Reservation::create($form);
        return redirect()->route('reservations');
    }

}
