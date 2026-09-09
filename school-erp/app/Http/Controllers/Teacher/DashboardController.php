<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher()->with('subjects.schoolClass')->first();
        $notices = Notice::where('school_id', $teacher?->school_id)->latest('publish_date')->take(5)->get();

        return view('teacher.dashboard', compact('teacher', 'notices'));
    }
}
