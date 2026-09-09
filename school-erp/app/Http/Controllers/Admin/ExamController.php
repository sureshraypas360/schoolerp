<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('schoolClass.school')->withCount('examSubjects')->latest()->paginate(15);

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $classes = SchoolClass::with('school')->orderBy('name')->get();

        return view('admin.exams.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $class = SchoolClass::findOrFail($data['class_id']);
        $data['school_id'] = $class->school_id;

        $exam = Exam::create($data);

        return redirect()->route('admin.exams.show', $exam)->with('status', 'পরীক্ষা তৈরি করা হয়েছে। এবার বিষয় যোগ করুন।');
    }

    public function show(Exam $exam)
    {
        $exam->load('examSubjects.subject', 'schoolClass');
        $subjects = Subject::where('class_id', $exam->class_id)->get();

        return view('admin.exams.show', compact('exam', 'subjects'));
    }

    public function addSubject(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'full_marks' => ['required', 'integer', 'min:1'],
            'pass_marks' => ['required', 'integer', 'min:0'],
            'exam_date' => ['nullable', 'date'],
        ]);

        $data['exam_id'] = $exam->id;

        ExamSubject::create($data);

        return back()->with('status', 'পরীক্ষার বিষয় যোগ করা হয়েছে।');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('status', 'পরীক্ষা মুছে ফেলা হয়েছে।');
    }
}
