<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\GuestHouse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;

class GuestHouseController extends Controller
{
    //

    public function index() {
        return Inertia::render('Admin/ManageGuesthouses', ['guesthouses' => GuestHouse::paginate(5)]);
    }

    public function manage_guesthouses_entry($entry) {
        return Inertia::render('Admin/ManageGuesthouses', ['guesthouses' => GuestHouse::paginate($entry), 'newEntry' => $entry]);
    }

    public function destroy(GuestHouse $guesthouse) {
        $wishlist = Wishlist::where('room_id', $guesthouse->id)->get();
        $wishlist->each->delete();
        $guesthouse->delete();
        return back();
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
