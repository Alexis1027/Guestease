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
        return Inertia::render('Admin/Dashboard', ['totalUsers' => User::count(), 'totalListings' => Listing::count()]);
    }
}
