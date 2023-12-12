<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;

class AdminListingController extends Controller
{
    //

    public function index() {
        $listings = Listing::where('status', '!=', 'Deleted')->where('status', '!=', 'For approval')->get();
        foreach($listings as $ls) {
            $ls->owner = User::find($ls->owner_id);
        }
        return Inertia::render('Admin/ManageListings', ['listings' => $listings]);
    }

    public function update(Listing $listing, Request $request) {
        $listing->status = $request->status;
        $listing->update();
        return back();
    }


    public function destroy(Listing $listing) {
        $listing->status = "Deleted";
        $listing->update();
        return back();
    }

    
}
