<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    //
    public function store(Request $request) {
        $form = $request->validate([
            'payment_process' => 'required'
        ]);
        $form['user_id'] = $request->user_id;
        $form['room_id'] = $request->room_id;
        $form['status'] = $request->status;
        Reservation::create($form);
        return redirect()->route('reservations');
    }
}
