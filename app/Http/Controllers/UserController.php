<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function login() {
        return Inertia::render('Auth/Login');
    }

    public function createUser() {
        return Inertia::render('Auth/CreateUser');
    }

    public function createOwner() {
        return Inertia::render('Auth/CreateOwner');
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You logged out?');
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
        return redirect('/')->with('message', 'Created and logged in successfully');
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
        return redirect('/')->with('message', 'Created and logged in successfully');
    }

    public function edit() {
        return Inertia::render('Auth/Edit');
    }

    public function index() {
        return Inertia::render('Auth/Index', ['users' => User::all()]);
    }

    public function destroy(User $user) {
        $user->delete();
        return back();
    }

    public function authenticate(Request $request) {
        $form = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($form)) {
            $request->session()->regenerate();
            return redirect('/');
        }
        else {
            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        }
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
