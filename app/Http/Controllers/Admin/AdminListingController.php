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

    public function index(?string $entry = null) {
        $listings = Listing::where('status', '!=', 'Deleted')->where('status', '!=', 'For approval')->paginate($entry ? $entry : 5);
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
