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
    public function index(?string $entry = null) {
        return Inertia::render('Admin/ManageUsers', ['users' => User::paginate($entry ? $entry : 5)]);
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
