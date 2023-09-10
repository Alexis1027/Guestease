<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function edit() {
        return Inertia::render('Auth/Edit');
    }

    public function index() {
        return Inertia::render('Admin/ManageUsers', ['users' => User::paginate(5)]);
    }

    public function manage_users_entry($entry) {
        return Inertia::render('Admin/ManageUsers', ['users' => User::paginate($entry)]);
    }

    public function destroy(User $user) {
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
