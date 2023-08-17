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

    public function register() {
        return Inertia::render('Auth/Register');
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You logged out?');
    }

    public function store(Request $request) {
        $form = $request->validate([
            'firstname' => ['required', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
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

    public function show() {
        return Inertia::render('Auth/Edit');
    }

    public function index() {
        $users = User::get();
        return Inertia::render('Auth/Index', ['users' => $users]);
    }

    public function delete(Request $request) {
        $user = User::find($request->id);
        $user->delete();
        return response()->json(['response' => 'HELLO GIATAY!', 'id' => $request->all()]);
    }

    public function authenticate(Request $request) {
        $form = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($form)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged in!');
        }
        else {
            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        }
    }

    public function update_name(Request $request) {
        
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->save();
        return back()->with('message', 'Successfully changed name!');
    }

    public function update_email(Request $request) {
        $user = User::find(auth()->user()->id);

        $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')]
        ]);

        $user->email = $request->email;
        $user->save();
        return back()->with('message', 'Successfully changed email!');
    }

    public function add_profile_pic(Request $request) {

        $user = User::find(auth()->user()->id);
        $user->profile_pic = $request->profile_pic;
        $user->save();
        return back()->with('message', 'Succesfully changed profile pic!');
    }

    public function add_phone(Request $request) {
        $user = User::find(auth()->user()->id);
        $user->contact_no = $request->contact_no;
        $user->save();
        return back()->with('message', 'Successfully added contact number!');
    }

    // public function update_phone(Request $request) {
    //     $user = User::find(auth()->user()->id);
    //     $user->contact_no = $request->
    // }

    public function add_address(Request $request) {
        $user = User::find(auth()->user()->id);
        $user->address = $request->address;
        $user->save();
        return back()->with('message', 'Successfully added Address');
    }
}
