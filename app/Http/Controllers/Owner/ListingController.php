<?php

namespace App\Http\Controllers\Owner;

use IntlChar;
use Exception;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ListingRequest;
use GuzzleHttp\Psr7\UploadedFile;

class ListingController extends Controller
{
    //
    public function create() {
        return Inertia::render('Owner/CreateListing');
    }

    public function index() {
        return Inertia::render('Owner/Listings', ['listings' => Listing::all()->where('owner_id', auth()->user()->id)]);
    }

    public function edit(Listing $listing) {
        return Inertia::render('Owner/EditListing', ['listing' => $listing]);
    }

    public function show(Listing $listing) {
        return Inertia::render('Owner/VerifyListing', ['listing' => $listing]);
    }

    public function verify_listing(Listing $listing, Request $request) {
        dd($request->file('bldg_permit'));
        return Inertia::render('Owner/VerifyListing', ['listing' => $listing]);
    }

    public function store(Request $request) {
        $houseImages = [];
        $uploadedFiles = $request->file('images');
        
        if($request->file('images') != null) {
            foreach($uploadedFiles as $file) {
                $houseImages[] = $file->getClientOriginalName();
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
        ]);
        $form['status'] = "For approval";
        $form['images'] = json_encode($houseImages);
        $form['amenities'] = json_encode($form['amenities']);
        try {
            $form['bldg_permit'] = $request->bldg_permit[0]->getClientOriginalName();
            Listing::create($form);
        }
        catch(Exception $e) {
            Listing::create($form);
        }
        return redirect('/owner/dashboard');

    }

    public function update_details(Listing $listing, Request $request) {
        $form = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
        ]);
        $listing->update(['title' => $form['title'], 'description' => $form['description'], 'location' => $form['location']]);
        return back();
    }

    public function destroy(Listing $listing) {
        $listing->delete();
        return redirect('/owner/dashboard');

    }
    
}
