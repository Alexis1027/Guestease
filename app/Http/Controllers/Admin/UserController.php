<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class UserController extends Controller
{
    //
    public function edit() {
        return Inertia::render('Auth/Edit');
    }

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

    public function update(Request $request) {
        
        $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'contact_no' => ['required', 'min:3'],
            'address' => ['required', 'min:3'],
            'email' => ['required'],
        ]);

        $user = auth()->user();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->contact_no = $request->input('contact_no');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        $user->update();
        return back();
 
    }

    
}
