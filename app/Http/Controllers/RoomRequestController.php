<?php

namespace App\Http\Controllers;

use App\Models\RoomRequest;
use Illuminate\Http\Request;

class RoomRequestController extends Controller
{
    //
    public function store(Request $request) {
        RoomRequest::create($request->all());
    }
}
