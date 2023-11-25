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
    public function index(?string $entry = null) {
        $reservations = Reservation::paginate($entry ? $entry : 5);
        // $reservations = Reservation::all();

        // $reservations = $reservations->reject(function ($r) {
        //     $listing = Listing::find($r->listing_id);
        //     return $listing == null;
        // });
        // dd($reservations);
        foreach($reservations as $rs) {
            $rs->user = User::find($rs->user_id);
            $rs->listing = Listing::find($rs->listing_id);
        }
        // if($reservations->total() == 0) {
        //     $reservations = [];
        // }
        return Inertia::render('Admin/ManageReservation', ['reservations' => $reservations]);
    }
}
