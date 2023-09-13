<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    //
    public function create() {
        return Inertia::render('Owner/CreateListing');
    }

    public function verify_listing(GuestHouse $guesthouse) {
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
            'bathrooms' => 'required'
        ]);
        $form['images'] = $houseImages;
        $form['amenities'] = json_encode($form['amenities']);
        GuestHouse::create($form);
        return back();

    }
    
}
