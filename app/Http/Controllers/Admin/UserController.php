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
        $users = User::where('role', '!=', 'admin')->select('id', 'firstname', 'lastname', 'email', 'address', 'phone_number', 'is_banned', 'role')->get();
        return Inertia::render('Admin/ManageUsers', ['users' => $users]);
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

    public function ban(User $user) {
        $user->is_banned = true;
        $user->update();
        return back();
    }

    public function unban(User $user) {
        $user->is_banned = false;
        $user->update();
        return back();
    }

    

    
}
