<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Listing;

class ListingRequestController extends Controller
{
    //
    public function index() {

        $listingRequests = Listing::all()->where('status', 'For approval');
        foreach($listingRequests as $r) {
            $r->user = User::find($r->owner_id);
        }
        return Inertia::render('Admin/ListingRequests', ['listingRequests' => $listingRequests]);
    }

    public function approve(Listing $listing) {
        $listing->status = 'Available';
        $listing->update();
        return back();
    }

    public function decline(Listing $listing) {
        $listing->status = 'Declined';
        $listing->update();
        return back();
    }

}
