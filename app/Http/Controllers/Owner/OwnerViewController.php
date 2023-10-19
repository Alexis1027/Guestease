<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Listing;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class OwnerViewController extends Controller
{
    //
    public function dashboard() {
        $listings = Listing::where('owner_id', auth()->user()->id)->latest()->get();

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

    public function calendar() {

        $listing = Listing::where('owner_id', auth()->user()->id)->first();
        $reservations = Reservation::where('listing_id', $listing->id)->get();

        return Inertia::render('Owner/Calendar', ['listing' => $listing, 'reservations' => $reservations]);
    }

}
