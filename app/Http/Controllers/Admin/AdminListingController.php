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

    public function index() {
        return Inertia::render('Admin/ManageListings', ['listings' => Listing::paginate(5)]);
    }

    public function manage_listing_entry($entry) {
        return Inertia::render('Admin/ManageListings', ['listings' => Listing::paginate($entry), 'newEntry' => $entry]);
    }

    public function destroy(Listing $listing) {
        $wishlist = Wishlist::where('listing_id', $listing->id)->get();
        $wishlist->each->delete();
        $listing->delete();
        return back();
    }

    //store guest hoseu data 
    
}