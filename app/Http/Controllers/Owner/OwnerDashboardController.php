<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerDashboardController extends Controller
{
    //
    public function dashboard() {
        $guesthouses = GuestHouse::where('owner_id', auth()->user()->id)->latest()->get();

        foreach($guesthouses as $gh) {
            $ratings = Rating::where('room_id', $gh->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $gh->averageRating = number_format($averageRating, 2);
        }

        return Inertia::render('Owner/Dashboard', [
            'guesthouses' => $guesthouses
        ]);
    }
}
