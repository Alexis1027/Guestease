<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AdminReservationController extends Controller
{
    //
    public function index() {
        $reservations = Reservation::all();
        
        foreach($reservations as $rs) {
            if ($rs->checkout < Carbon::now()) {
                $rs->status = 'completed';
                $rs->save();
            }
            $rs->user = User::find($rs->user_id);
            $listing = Listing::find($rs->listing_id);
            $rs->listing = $listing;
            $rs->owner = User::find($listing->owner_id);
        }
   
        return Inertia::render('Admin/ManageReservation', ['reservations' => $reservations]);
    }
}
