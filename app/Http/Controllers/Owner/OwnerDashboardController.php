<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerDashboardController extends Controller
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
}
