<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class GuestHouseController extends Controller
{
    //

    public function index() {
        //dd(request('search'));
        $guesthouses = GuestHouse::latest()->filter(request(['search']))->get();

        foreach($guesthouses as $gh) {
            $ratings = Rating::where('room_id', $gh->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings) : 0;
            $gh->averageRating = number_format($averageRating, 2);
        }

        return Inertia::render('GuestHouse/Index', [
            'guesthouses' => $guesthouses
        ]);
    }

    //show singular guest house
    public function show(GuestHouse $id) {
        if(auth()->user()) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)
                ->where('room_id', $id->id)
                ->first();

            $rating = Rating::where('user_id', auth()->user()->id)
            ->where('room_id', $id->id)
            ->first();
            
            if($rating) {
                $rating->user = User::find(auth()->user()->id);
            }

            $ratings = Rating::where('room_id', $id->id)
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

            return Inertia::render('GuestHouse/Show', [
                'guesthouse' => $id,
                'wishlist' => $wishlist, 
                'rated' => $rating,
                'ratings' => $ratings,
                'averageRating' => $averageRating
            ]);
            
        }
        else {
            $ratings = Rating::where('room_id', $id->id)
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
            return Inertia::render('GuestHouse/Show', [
                'guesthouse' => $id, 
                'ratings' => $ratings, 
                'averageRating' => $averageRating]);
        }
    }

    //create guest house


    public function payment(Request $request, GuestHouse $guesthouse) {

        $ratings = Rating::where('room_id', $guesthouse->id)->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings)+1 : 0;
            $averageRating = number_format($averageRating, 2);

        return view('guesthouses.payment', ['guesthouse' => $guesthouse, 'averageRating' => $averageRating, 'ratings' => $ratings]);
    }

    public function update(Request $request, GuestHouse $guesthouse) {
        $houseImages = '';
        $uploadedFiles = $request->file('room_image');
        if($uploadedFiles == null) {
           $houseImages = $request->room_image;
        }
        else {
            for($i = 0; $i < count($uploadedFiles); $i++) {
                if($i != count($uploadedFiles)-1) {
                    $houseImages .= $uploadedFiles[$i]->getClientOriginalName().",";
                }
                else {
                    $houseImages .= $uploadedFiles[$i]->getClientOriginalName();
                }
            }
        }
        

        $form = $request->validate([
            'room_name' => 'required',
            'room_details' => 'required',
            'room_location' => 'required',
            'room_price' => 'required',
            'room_image' => 'required|min:5'
        ]);

        $form['room_image'] = $houseImages;

        $guesthouse->update($form);
        $rating = Rating::where('user_id', auth()->user()->id)
            ->where('room_id', $guesthouse->id)
            ->first();

            $ratings = Rating::where('room_id', $guesthouse->id)
            ->whereIn('user_id', function($query) {
                $query->select('id')->from('users');
            })
            ->get();
            $totalRatings = count($ratings);
            $sumRatings = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? ($sumRatings / $totalRatings)+1 : 0;
            $averageRating = number_format($averageRating, 2);

            foreach($ratings as $r) {
                $r->user = User::find($r->user_id);
            }


        return view('guesthouses.show', [
            'guesthouse' => $guesthouse, 
            'rating' => $rating, 
            'ratings' => $ratings, 
            'averageRating' => $averageRating
        ])
        ->with('message', 'GUEST HOUSE UPDATED SUCCESSFULLY!');
        // return redirect('guesthouses.show', ['room' => $guesthouse])->with('message', 'Guest House Updated Successfully!');
    }

    public function destroy(GuestHouse $guesthouse) {
        dd($guesthouse);
        $wishlist = Wishlist::where('room_id', $guesthouse->id)->get();
        $wishlist->each->delete();
        $guesthouse->delete();

        return redirect('/')->with('message', "GUEST HOUSE DELETED SUCCESSFULLY!");
    }

    //store guest hoseu data 
    public function store(Request $request) {
        $houseImages = '';
        $uploadedFiles = $request->file('room_image');
        
        if($request->file('room_image') != null) {
            for($i = 0; $i < count($uploadedFiles); $i++) {
                if($i != count($uploadedFiles)-1) {
                    $houseImages .= $uploadedFiles[$i]->getClientOriginalName().",";
                }
                else {
                    $houseImages .= $uploadedFiles[$i]->getClientOriginalName();
                }
            }
        }

        $form = $request->validate([
            'room_name' => 'required',
            'room_details' => 'required',
            'room_location' => 'required',
            'room_price' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $form['room_image'] = $houseImages;
        GuestHouse::create($form);

        return back();

    }
}
