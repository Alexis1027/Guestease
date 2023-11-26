<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Listing;
use App\Http\Controllers\Controller;

class OwnerViewController extends Controller
{
    //
    public function dashboard() {
        $listings = Listing::where('owner_id', auth()->user()->id)->where('status', '!=', 'Deleted')->latest()->get();

        foreach($listings as $ls) {
            $ratings = Rating::where('listing_id', $ls->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $ls->averageRating = number_format($averageRating, 2);
        }

        return Inertia::render('Owner/Dashboard', [
            'listings' => $listings
        ]);
    }

    // public function calendar(Listing $listing) {

    //     if(!$listing->exists) {
    //         $listing = Listing::where('owner_id', auth()->user()->id)->first();
    //     }

    //     $listings = Listing::where('owner_id', auth()->user()->id)->select(['id', 'title'])->get();
    //     $reservations = [];
    //     if($listing) {
    //         $reservations = Reservation::where('listing_id', $listing->id)->get();
    //     }

    //     foreach($reservations as $rs) {
    //         $rs->user = User::find($rs->user_id);
    //     }

    //     return Inertia::render('Owner/Calendar', ['listing' => $listing, 'listings' => $listings, 'reservations' => $reservations]);
    // }

}
