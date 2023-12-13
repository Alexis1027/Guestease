<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    //
    public function index() {

        $reports = Report::all();

        foreach($reports as $r) {
            $r->guest = User::find($r->user_id);
            $r->owner = User::find($r->owner_id);
        }

        return Inertia::render('Admin/ReportedGuests', ['reports' => $reports]);
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

    public function destroy(Report $report) {
        $report->delete();
        return back();
    }

}
