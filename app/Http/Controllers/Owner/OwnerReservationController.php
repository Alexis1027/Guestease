<?php

namespace App\Http\Controllers\Owner;

use stdClass;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerReservationController extends Controller
{
    //
    public function index() {
        $listings = Listing::where('owner_id', auth()->user()->id)->get();
        $reservations = [];
        foreach($listings as $ls) {
            //find the rooms of owner and find the rooms in the reservation table,
            $res = Reservation::where('listing_id', $ls->id)->get();
            foreach($res as $r) {
                $r->listing = Listing::select(['title', 'images', 'id'])->find($r->listing_id);
                $r->user = User::select(['firstname', 'lastname', 'profile_pic', 'email', 'phone_number', 'id'])->find($r->user_id);
                array_push($reservations, $r);
            }
        }
        return Inertia::render('Owner/Reservations', ['reservations' => $reservations]);
    }

    public function update(Reservation $reservation, Request $request) {
        $listing = Listing::find($request->listing_id);
        if(($listing->type == "Room" || $listing->type == "Guest house") && $request->status == "approved") {
            $listing->status = "Not available";
            $listing->update();
        }
        $reservation->status = $request->status;
        $reservation->update();
        return back();
    }

}
