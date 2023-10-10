<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminReservationController extends Controller
{
    //
    public function index() {
        $reservations = Reservation::all();
        foreach($reservations as $rs) {
            $rs->user = User::find($rs->user_id);
            $rs->listing = Listing::find($rs->listing_id);
        }
        return Inertia::render('Admin/ManageReservation', ['reservations' => $reservations]);
    }
}
