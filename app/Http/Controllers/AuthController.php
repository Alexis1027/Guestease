<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        return back()->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Cache-Control', 'post-check=0, pre-check=0')
        ->header('Pragma', 'no-cache');
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

    public function forgot_password() {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function verify() {
        return Inertia::render('Auth/Verify');
    }

    public function authenticate(Request $request) {
        // $form = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => 'required'
        // ]);

        $request->session()->regenerate();
        $user = User::where('email',$request->email)->first();
        auth()->login($user);
        switch(auth()->user()->role) {
            case 'admin':
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

    public function storeUser(Request $request) {
        $form = $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);
        //hash password
        $form['role'] = 'user';
        $form['password'] = bcrypt($form['password']);
        $user = User::create($form);
        $user->profile_pic = "default_profile.png";
        $user->save();
        // auth()->login($user);
        return redirect('/login');
    }

    public function storeOwner(Request $request) {
        $form = $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);
        //hash password
        $form['role'] = 'owner';
        $form['password'] = bcrypt($form['password']);
        $user = User::create($form);
        $user->profile_pic = "default_profile.png";
        $user->save();
        // auth()->login($user);
        return redirect('/login');
    }

}
