<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    //
    public function dashboard() {

        return Inertia::render('Admin/Dashboard', [
            'total_users' => User::count(),
            'total_listings' => Listing::count(),
            'approved_listings' => Listing::where('status', 'Available')->count(),
            'pending_listings' => Listing::where('status', 'For approval')->count(),
            'declined_listings' => Listing::where('status', 'Declined')->count(),
            'available_listings' => Listing::where('status', 'Available')->count(),
            'not_available_listings' => Listing::where('status', 'Not available')->count(),
            'guests' => User::where('role', 'guest')->count(),
            'owners' => User::where('role', 'owner')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ]);
    }
}
