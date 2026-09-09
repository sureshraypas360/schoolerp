<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher()->with('subjects.schoolClass')->first();
        $homeworks = Homework::where('teacher_id', $teacher?->id)->with('subject', 'section')->latest()->get();

        return view('teacher.homework.index', compact('teacher', 'homeworks'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
        ]);

        $data['teacher_id'] = $teacher->id;
        $data['given_date'] = now();

        Homework::create($data);

        return back()->with('status', 'হোমওয়ার্ক দেওয়া হয়েছে।');
    }

    public function destroy(Homework $homework)
    {
        $homework->delete();

        return back()->with('status', 'হোমওয়ার্ক মুছে ফেলা হয়েছে।');
    }
}
