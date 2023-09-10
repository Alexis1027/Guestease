<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestHouseRequestController extends Controller
{
    //
    public function requests() {

        $requests = RoomRequest::all();
        foreach($requests as $r) {
            $r->user = User::find($r->user_id);
        }
        return Inertia::render('Admin/Requests', ['requests' => $requests]);
    }
}
