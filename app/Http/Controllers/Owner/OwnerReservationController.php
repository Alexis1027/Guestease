<?php

namespace App\Http\Controllers\Owner;

use stdClass;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\Reservation;
use App\Http\Controllers\Controller;

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
                $r->listing = Listing::select(['title', 'images'])->find($r->listing_id);
                $r->user = User::select(['firstname', 'lastname', 'profile_pic', 'email', 'phone_number'])->find($r->user_id);
                array_push($reservations, $r);
            }
        }
        return Inertia::render('Owner/Reservations', ['reservations' => $reservations]);
    }
}
