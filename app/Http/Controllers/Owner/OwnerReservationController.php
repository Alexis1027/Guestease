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
    public function index(?string $entry = null) {
        
        $listings = Listing::where('owner_id', auth()->user()->id)->paginate($entry ? (int) $entry : 5);
        $reservations = [];
        foreach($listings as $ls) {
            //find the rooms of owner and find the rooms in the reservation table,
            $res = Reservation::where('listing_id', $ls->id)->get();
            foreach($res as $r) {
                $r->listing = Listing::select(['title', 'images', 'id', 'status'])->find($r->listing_id);
                $r->user = User::select(['firstname', 'lastname', 'profile_pic', 'email', 'phone_number', 'id'])->find($r->user_id);
                array_push($reservations, $r);
            }
        }
        foreach ($reservations as $r) {
            if ($r->checkout < now()) {
                $this->updateReservationStatus($r->id);
 // Save the individual reservation
            }
        }
        return Inertia::render('Owner/Reservations', ['reservations' => $reservations]);
    }

    public function updateReservationStatus($id) {
        $reservation = Reservation::find($id);
        $reservation->status = "completed";
        $reservation->update();
    } 

    public function update(Reservation $reservation, Request $request) {
        
        $listing = Listing::find($request->listing_id);
        // if(($listing->type == "Room" || $listing->type == "Guest house") && $request->status == "approved") {
        //     $listing->status = "Not available";
        //     $listing->update();
        // }

        if(($listing->type == "Room" || $listing->type == "Guest house") && $request->status == "cancelled") {
            $listing->status = "Available";
            $listing->update();
        }

        $reservation->status = $request->status;
        $reservation->update();
        return back();
    }

    public function destroy(Reservation $reservation) {
        $reservation->delete();
        return back();
    }

}
