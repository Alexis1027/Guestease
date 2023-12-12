<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class UserController extends Controller
{
    //
    public function index() {
        return Inertia::render('Admin/ManageUsers', ['users' => User::select('id', 'firstname', 'lastname', 'email', 'address', 'phone_number', 'role')->get()]);
    }

    public function destroy(User $user) {
        $listing = Listing::where('owner_id', $user->id)->get();
        foreach($listing as $ls) {
            Reservation::where('listing_id', $ls->id)->delete();
            $ls->delete();
        }
        $user->delete();
        return back();
    }

    

    
}
