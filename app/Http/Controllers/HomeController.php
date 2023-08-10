<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index() {
        return Inertia::render('GuestHouse/Index');
    }

    public function show() {
        return Inertia::render('GuestHouse/Show');
    }

    public function about() {
        return Inertia::render('About');
    }

    public function map() {
        return Inertia::render('Map/Index');
    }

}
