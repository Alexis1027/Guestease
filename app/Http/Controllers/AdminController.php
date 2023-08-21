<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\GuestHouse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    
    public function dashboard() {
        return Inertia::render('Admin/Dashboard');
    }

    public function create() {
        return Inertia::render('GuestHouse/Create');
    }

    public function createAdmin() {
        return Inertia::render('Auth/CreateAdmin');
    }

    public function edit(GuestHouse $guesthouse) {
        return Inertia::render('GuestHouse/Edit', ['guesthouse' => $guesthouse]);
    }

    public function manage_guesthouse() {
        return Inertia::render('Admin/ManageGuesthouse');
    }

}
