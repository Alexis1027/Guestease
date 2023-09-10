<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationController extends Controller
{
    //
    public function index() {
        return Inertia::render('Admin/ManageReservation', ['reservations' => Reservation::all()]);
    }
}
