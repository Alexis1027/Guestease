<?php

namespace App\Http\Controllers\Guest;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationRequestController extends Controller
{
    //
    public function store(Request $request) {
        $form = $request->validate([
            'payment_process' => 'required'
        ]);
        $form['user_id'] = $request->user_id;
        $form['room_id'] = $request->room_id;
        $form['status'] = $request->status;
        $form['checkin'] = $request->checkin;
        $form['checkout'] = $request->checkout;
        $form['guests'] = $request->guests;
        $form['total'] = $request->total;
        Reservation::create($form);
        return redirect()->route('reservations');
    }

    

}
