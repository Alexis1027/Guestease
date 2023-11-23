<?php

namespace App\Http\Controllers\Owner;

use Exception;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    //
    public function create() {
        return Inertia::render('Owner/CreateListing');
    }

    public function index(?string $entry = null) {
        return Inertia::render('Owner/Listings', ['listings' => Listing::where('owner_id', auth()->user()->id)->paginate($entry ? $entry : 5)]);
    }

    public function edit(Listing $listing) {
        return Inertia::render('Owner/EditListing', ['listing' => $listing]);
    }

    public function store(Request $request) {
        $houseImages = [];
        $uploadedFiles = $request->file('images');
        
        if($request->file('images') != null) {
            foreach($uploadedFiles as $file) {
                $houseImages[] = $file->getClientOriginalName();
                $file->move(public_path('/images/uploads'), $file->getClientOriginalName());
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
        $form['status'] = "For approval";
        $form['rules'] = json_encode($request->rules);
        $form['images'] = json_encode($houseImages);
        $form['amenities'] = json_encode($form['amenities']);
        try {
            $form['bldg_permit'] = $request->bldg_permit[0]->getClientOriginalName();
            $request->bldg_permit[0]->move(public_path('/images/uploads'), $request->bldg_permit[0]->getClientOriginalName());
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

    public function update_photos(Listing $listing, Request $request) {
        $listing->images = json_encode($request->images);
        $listing->update();
        return back();
    }

    public function update_rules(Listing $listing, Request $request) {
        $rules = json_decode($listing->rules);
        // check if rules has value
        if($rules) {
            array_push($rules, $request->newRule);
            $listing->rules = json_encode($rules);
            $listing->update();
            return back();
        }
        else {
            $arr = [$request->newRule];
            $listing->rules = json_encode($arr);
            $listing->update();
            return back();
        }
        
    }

    public function update_property(Listing $listing, Request $request) {
        $listing->guests = $request->guests;
        $listing->beds = $request->beds;
        $listing->rooms = $request->rooms;
        $listing->bathrooms = $request->bathrooms;
        $listing->amenities = json_encode($request->amenities);
        $listing->update();
        return back();
    }

    public function update_pricing(Listing $listing, Request $request) {
        $listing->price = $request->price;
        $listing->monthly_discount = intval($request->monthly_discount, 10);
        $listing->status = $request->status;
        $listing->update();
        return back();
    }

    public function destroy(Listing $listing) {
        $listing->delete();
        return redirect('/owner/dashboard');
    }
    
}
