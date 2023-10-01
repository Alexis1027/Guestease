<?php

namespace App\Http\Controllers\Guest;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    //
    public function index() {
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();

        foreach($wishlists as $wishlist) {
            $wishlist->guesthouse = GuestHouse::find($wishlist->room_id);
            $wishlist->rating = Rating::find($wishlist->room_id);
            $ratings = Rating::where('room_id', $wishlist->room_id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings)+1 : 0;
            $wishlist->averageRating = number_format($averageRating, 2);
            $wishlist->totalRatings = $totalRatings;
        }
        return Inertia::render('Guest/Wishlist', ['wishlists' => $wishlists]);
    }

    public function store(Request $request) {

        Wishlist::create($request->all());
        return back();
    }

    public function destroy(Request $request) {
        $wishlist = Wishlist::where('user_id', $request->user_id)
                            ->where('room_id', $request->room_id)
                            ->firstOrFail();
        $wishlist->delete();

        return back();
    }
}
