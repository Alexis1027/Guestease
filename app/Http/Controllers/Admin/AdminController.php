<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\GuestHouse;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function create() {
        return Inertia::render('Admin/CreateAdmin');
    }
 

}
