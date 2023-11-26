<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Listing;

class ListingRequestController extends Controller
{
    //
    public function index(?string $entry = null) {

        $listingRequests = Listing::where('status', 'For approval')->paginate($entry ? $entry : 5);
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

    public function reject(Listing $listing) {
        $listing->status = 'Rejected';
        $listing->update();
        return back();
    }

}
