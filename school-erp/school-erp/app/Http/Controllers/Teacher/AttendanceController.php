<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function create(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $sections = Section::whereHas('schoolClass.subjects.teachers', function ($q) use ($teacher) {
            $q->where('teachers.id', $teacher?->id);
        })->orWhereHas('schoolClass', fn ($q) => $q->where('school_id', $teacher?->school_id))
            ->distinct()->orderBy('name')->get();

        $sectionId = $request->get('section_id', $sections->first()?->id);
        $date = $request->get('date', now()->toDateString());

        $students = collect();
        $existing = collect();

        if ($sectionId) {
            $students = \App\Models\Student::with('user')->where('section_id', $sectionId)->orderBy('roll_no')->get();
            $existing = Attendance::where('section_id', $sectionId)
                ->whereDate('date', $date)
                ->pluck('status', 'student_id');
        }

        return view('teacher.attendance.create', compact('sections', 'sectionId', 'date', 'students', 'existing'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'date' => ['required', 'date'],
            'statuses' => ['required', 'array'],
            'statuses.*' => ['required', 'in:present,absent,late,leave'],
        ]);

        foreach ($data['statuses'] as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $data['date']],
                [
                    'section_id' => $data['section_id'],
                    'status' => $status,
                    'marked_by' => $request->user()->id,
                ]
            );
        }

        return back()->with('status', 'উপস্থিতি সংরক্ষণ করা হয়েছে।');
    }
}
