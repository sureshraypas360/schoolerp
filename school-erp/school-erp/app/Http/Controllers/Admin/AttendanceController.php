<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::with('schoolClass')->orderBy('name')->get();

        $query = Attendance::with(['student.user', 'section.schoolClass']);

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->latest('date')->paginate(30)->withQueryString();

        return view('admin.attendance.index', compact('attendances', 'sections'));
    }
}
