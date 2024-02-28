<?php

namespace App\Http\Controllers\Guest;

use Inertia\Inertia;
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

    public function confirm_reservation(Listing $listing, Request $request) {
        $request->validate([
            'guests' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'days' => 'required',
        ]);

        return Inertia::render('Guest/ConfirmReservation', [
            'listing' => $listing, 
            'guests' => $request->query('guests'),
            'checkin' => $request->query('checkin'),
            'checkout' => $request->query('checkout'),
            'days' => $request->query('days')
        ]);
    }

    public function index() {
        $reservations = Reservation::where('user_id', auth()->user()->id)->latest()->get();
        
        foreach ($reservations as $r) {
            $listing = Listing::find($r->listing_id);
            $r->listing = $listing;
        }
        return Inertia::render('Guest/Reservations', ['reservations' => $reservations]);
    }

    public function store(Listing $listing, Request $request) {

        $form = $request->validate([
            'payment_process' => 'required',
        ]);

        if ($request->hasFile('payment_screenshot') && $request->payment_process == 'Gcash') {

            $request->payment_screenshot[0]->move(public_path('/images/payment_screenshots'), $request->payment_screenshot[0]->getClientOriginalName());
            $form['payment_screenshot'] = $request->payment_screenshot[0]->getClientOriginalName();

        }
        // $form = $request->validate([
        //     'payment_process' => 'required',
        // ]);
        
        // if($request->payment_process == 'Gcash') {
        //     $request->payment_screenshot[0]->move(public_path('/images/payment_screenshots'), $request->payment_screenshot[0]->getClientOriginalName());
        //     $form['payment_screenshot'] = $request->payment_screenshot[0]->getClientOriginalName();
        // }
        
        $form['days'] = $request->days;
        $form['user_id'] = $request->user_id;
        $form['listing_id'] = $request->listing_id;
        $form['status'] = $request->status;
        $form['discount'] = $request->discount;
        $form['checkin'] = $request->checkin;
        $form['checkout'] = $request->checkout;
        $form['guests'] = $request->guests;
        $form['total'] = $request->total;
        Reservation::create($form);
        return redirect()->route('reservations');
    }

}
