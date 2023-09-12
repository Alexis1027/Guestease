<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    //
    public function create() {
        return Inertia::render('Owner/CreateListing');
    }

    public function store(Request $request) {
        dd($request);
    }
    
}
