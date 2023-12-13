<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    //
    public function index() {
        return Inertia::render('Admin/Reports', ['reports' => Report::all()]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'user_id' => 'required',
            'reason' => 'required'
        ]);

        $data['owner_id'] = auth()->user()->id;
        $data['status'] = 'reported';
        Report::create($data);
        return back();

    }

}
