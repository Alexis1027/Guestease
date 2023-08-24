<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //

    public function store(Request $request) {
        $request->validate([
            'rating' => 'required'
        ]);
        Rating::create($request->all());
        // return back()->with('message', 'Ratings and review added.');
            $rating = Rating::where('user_id', $request->user_id)
            ->where('room_id', $request->room_id)
            ->first();

            $ratings = Rating::where('room_id', $request->room_id)
            ->whereIn('user_id', function($query) {
                $query->select('id')->from('users');
            })
            ->get();

            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $averageRating = number_format($averageRating, 2);
            foreach($ratings as $r) {
                $r->user = User::find($r->user_id);
            }
        return back();
    }

}
