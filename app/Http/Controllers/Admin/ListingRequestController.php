<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ListingRequest;

class ListingRequestController extends Controller
{
    //
    public function index() {

        $requests = ListingRequest::all();
        foreach($requests as $r) {
            $r->user = User::find($r->user_id);
        }
        return Inertia::render('Admin/ListingRequests', ['requests' => $requests]);
    }
}
