<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;

class AdminListingController extends Controller
{
    //

    public function index(?string $entry = null) {
        $listings = Listing::paginate($entry ? $entry : 5);
        foreach($listings as $ls) {
            $ls->owner = User::find($ls->owner_id);
        }
        return Inertia::render('Admin/ManageListings', ['listings' => $listings]);
    }

    // public function data_table(?string $entry = null) {
    //     $listings = Listing::paginate($entry ? $entry : 5);
    //     // $listings = Listing::all();
    //     foreach($listings as $ls) {
    //         $ls->owner = User::find($ls->owner_id);
    //     }
    //     return Inertia::render('Admin/DataTable', ['listings' => $listings]);
    // }

    public function update(Listing $listing, Request $request) {
        $listing->status = $request->status;
        $listing->update();
        return back();
    }

    // public function manage_listing_entry($entry) {
    //     return Inertia::render('Admin/ManageListings', ['listings' => Listing::paginate($entry), 'newEntry' => $entry]);
    // }

    public function destroy(Listing $listing) {
        $listing->delete();
        // $wishlist = Wishlist::where('listing_id', $listing->id)->get();
        // $wishlist->each->delete();
        // $listing->delete();
        return back();
    }

    //store guest hoseu data 
    
}
