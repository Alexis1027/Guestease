<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\GuestHouse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function login() {
        if(!auth()->user()) {
            return Inertia::render('Auth/Login');
        }
        return back();
    }

    public function create_guest() {
        return Inertia::render('Auth/CreateGuest');
    }

    public function create_owner() {
        return Inertia::render('Auth/CreateOwner');
    }

    public function authenticate(Request $request) {
        $form = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($form)) {
            $request->session()->regenerate();

            switch(auth()->user()->role) {
                case 'admin':
                    // return redirect()->route('reservations');
                    return redirect('/admin/dashboard');
                    break;
                case 'owner':
                    return redirect('/owner/dashboard');
                    break;
                case 'guest':
                    return redirect('/');
                    break;
            }
            return redirect('/');
        }
        else {
            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        }
    }

    public function storeUser(Request $request) {
        $form = $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'terms' => ['required', 'accepted']
        ]);
        //hash password
        $form['role'] = 'user';
        $form['password'] = bcrypt($form['password']);
        $user = User::create($form);
        $user->profile_pic = "default_profile.png";
        $user->save();
        auth()->login($user);
        return redirect('/');
    }

    public function storeOwner(Request $request) {
        $form = $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'terms' => ['required', 'accepted']
        ]);
        //hash password
        $form['role'] = 'owner';
        $form['password'] = bcrypt($form['password']);
        $user = User::create($form);
        $user->profile_pic = "default_profile.png";
        $user->save();
        auth()->login($user);
        return redirect('/owner/dashboard');
    }

}
