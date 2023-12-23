<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    //
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'message' => 'required'
        ]);
        Contact::create($data);
        return back();
    }

    public function index() {
        return Inertia::render('Admin/ContactFormSubbmisions', ['messages' => Contact::all()]);
    }

    public function destroy(Contact $message) {
        $message->delete();
        return back();
    }

} 
