<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function change_password(User $user, Request $request) {
        $data = $request->validate([
            'currentPassword' => 'required',
            'new_password' => ['required', 'confirmed', 'min:6']
        ]);
        $auth = Auth::user();

        if(!Hash::check($data['currentPassword'], $auth->password)) {
            return back()->withErrors(['currentPassword' => 'Current password is invalid.']);
        }

        if(strcmp($data['currentPassword'], $data['new_password']) == 0) {
            return back()->withErrors(['new_password' => 'New Password cannot be same as your current password.']);
        }

        $auth->password = Hash::make($request->new_password);
        $auth->save();
        return back();
    }

}
