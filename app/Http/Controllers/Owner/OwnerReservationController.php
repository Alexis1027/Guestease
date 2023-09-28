<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class OwnerReservationController extends Controller
{
    //
    public function index() {
        return Inertia::render('Owner/Reservations');
    }
}
