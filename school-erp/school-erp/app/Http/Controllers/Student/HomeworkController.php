<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $homeworks = Homework::where('section_id', $student?->section_id)
            ->with('subject', 'teacher.user')
            ->latest()
            ->paginate(20);

        return view('student.homework', compact('homeworks'));
    }
}
