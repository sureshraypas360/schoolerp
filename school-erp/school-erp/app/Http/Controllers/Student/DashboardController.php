<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student()->with('schoolClass', 'section')->first();
        $notices = Notice::where('school_id', $student?->school_id)->latest('publish_date')->take(5)->get();

        $attendanceSummary = [];
        if ($student) {
            $attendanceSummary = $student->attendances()
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');
        }

        return view('student.dashboard', compact('student', 'notices', 'attendanceSummary'));
    }
}
