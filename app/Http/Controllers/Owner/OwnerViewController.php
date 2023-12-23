<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Listing;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class OwnerViewController extends Controller
{
    //
    public function dashboard() {
        $total_earnigns = Reservation::where('status', 'approved')->orWhere('status', 'completed')->sum('total');
        $total = $total_earnigns * 0.10;
        $total_listings = Listing::where('owner_id', auth()->user()->id)->count();
        $pending_listings = Listing::where('owner_id', auth()->user()->id)->where('status', 'For approval')->count();
        $approved_listings = Listing::where('owner_id', auth()->user()->id)->where('status', 'Available')->count();
        $total_reservations = Reservation::count();
        $pending_reservations = Reservation::where('status', 'pending')->count();


        $listings = Listing::where('owner_id', auth()->user()->id)->where('status', '!=', 'Deleted')->latest()->get();

        foreach($listings as $ls) {
            $ratings = Rating::where('listing_id', $ls->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $ls->averageRating = number_format($averageRating, 2);
        }

        return Inertia::render('Owner/Dashboard', [
            'listings' => $listings,
            'total_listings' => $total_listings,
            'pending_listings' => $pending_listings,
            'approved_listings' => $approved_listings,
            'total_reservations' => $total_reservations,
            'pending_reservations' => $pending_reservations,
            'total_earnings' => $total_earnigns - $total
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
