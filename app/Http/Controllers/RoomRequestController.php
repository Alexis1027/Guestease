<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoomRequest;
use Illuminate\Http\Request;

class RoomRequestController extends Controller
{
    //
    public function store(Request $request) {
        User::where('id', auth()->user()->id)->update(['room_requested' => 1]);
        RoomRequest::create($request->all());
    }
}
