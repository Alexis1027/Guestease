<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\Reservation;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    //
    public function dashboard() {

        return Inertia::render('Admin/Dashboard', [
            'total_users' => User::count(),
            'total_listings' => Listing::count(),
            'pending_listings' => Listing::where('status', 'For approval')->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'guests' => User::where('role', 'guest')->count(),
            'owners' => User::where('role', 'owner')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ]);
    }
}
