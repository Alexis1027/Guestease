<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use IntlChar;

class ListingController extends Controller
{
    //
    public function create() {
        return Inertia::render('Owner/CreateListing');
    }

    public function index() {
        return Inertia::render('Owner/Listing', ['guesthouses' => GuestHouse::all()->where('owner_id', auth()->user()->id)]);
    }

    public function edit(GuestHouse $guesthouse) {
        return Inertia::render('Owner/EditListing', ['guesthouse' => $guesthouse]);
    }

    public function show(GuestHouse $guesthouse) {
        return Inertia::render('Owner/VerifyListing', ['guesthouse' => $guesthouse]);
    }

    public function verify_listing(GuestHouse $guesthouse, Request $request) {
        dd($request->file('bldg_permit'));
        return Inertia::render('Owner/VerifyListing', ['guesthouse' => $guesthouse]);
    }

    public function store(Request $request) {
        $houseImages = '';
        $uploadedFiles = $request->file('images');
        
        if($request->file('images') != null) {
            for($i = 0; $i < count($uploadedFiles); $i++) {
                if($i != count($uploadedFiles)-1) {
                    $houseImages .= $uploadedFiles[$i]->getClientOriginalName().",";
                }
                else {
                    $houseImages .= $uploadedFiles[$i]->getClientOriginalName();
                }
            }
        }
        $form = $request->validate([
            'owner_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'price' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'guests' => 'required',
            'beds' => 'required',
            'amenities' => 'required',
            'rooms' => 'required',
            'bathrooms' => 'required',
            'type' => 'required'
        ]);
        $form['status'] = "To be processed";
        $form['images'] = $houseImages;
        $form['amenities'] = json_encode($form['amenities']);
        GuestHouse::create($form);
        return redirect('/owner/dashboard');

    }
    
}
