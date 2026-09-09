<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with(['user', 'school', 'schoolClass', 'section'])->orderBy('admission_no')->get();
        $selected = null;

        if ($request->filled('student_id')) {
            $selected = Student::with(['user', 'school', 'schoolClass', 'section'])->find($request->student_id);
        }

        return view('admin.idcards.index', compact('students', 'selected'));
    }
}
