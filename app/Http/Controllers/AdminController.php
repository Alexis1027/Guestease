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
        return Inertia::render('Admin/Dashboard', ['totalUsers' => User::count(), 'totalGuesthouses' => GuestHouse::count()]);
    }

    public function createAdmin() {
        return Inertia::render('Admin/CreateAdmin');
    }

    public function requests() {
        return Inertia::render('Admin/Requests');
    }

    public function manage_guesthouses() {
        return Inertia::render('Admin/ManageGuesthouses', ['guesthouses' => GuestHouse::paginate(5)]);
    }

    public function manage_guesthouses_entry($entry) {
        return Inertia::render('Admin/ManageGuesthouses', ['guesthouses' => GuestHouse::paginate($entry), 'newEntry' => $entry]);
    }

    public function manage_users_entry($entry) {
        return Inertia::render('Admin/ManageUsers', ['users' => User::paginate($entry)]);
    }

    public function manage_users() {
        return Inertia::render('Admin/ManageUsers', ['users' => User::paginate(5)]);
    }

    public function manage_reservations() {
        return Inertia::render('Admin/ManageReservation');
    }

}
