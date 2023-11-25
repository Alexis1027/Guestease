<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //

    public function index() {
        return Inertia::render('Account');
    }

    public function update(Request $request) {
        
        $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'phone_number' => ['required', 'min:3'],
            'address' => ['required', 'min:3'],
        ]);

        $user = auth()->user();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        $user->update();
        return back();
 
    }

    public function update_profile_pic(Request $request) {
        $user = Auth::user();
        $user->profile_pic = $request->file('profile_pic')[0]->getClientOriginalName();
        $user->update();
        $request->file('profile_pic')[0]->move(public_path('/images/profile'), $request->file('profile_pic')[0]->getClientOriginalName());
        return back();
    }

}
