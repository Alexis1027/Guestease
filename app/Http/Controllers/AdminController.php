<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function manage_guesthouses() {
        return Inertia::render('Admin/ManageGuesthouses', ['guesthouses' => GuestHouse::paginate(5)]);
    }

    public function manage_guesthouses_entry($entry) {
        return Inertia::render('Admin/ManageGuesthouses', ['guesthouses' => GuestHouse::paginate($entry)]);
    }

    public function manage_users() {
        return Inertia::render('Admin/ManageUsers', ['users' => User::paginate(5)]);
    }

    public function manage_reservations() {
        return Inertia::render('Admin/ManageReservation');
    }

}