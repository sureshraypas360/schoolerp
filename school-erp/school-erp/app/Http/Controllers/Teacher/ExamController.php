<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSubject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $exams = Exam::where('school_id', $teacher?->school_id)
            ->with(['schoolClass', 'examSubjects.subject'])
            ->latest()->get();

        return view('teacher.exams.index', compact('exams'));
    }

    public function marks(ExamSubject $examSubject)
    {
        $examSubject->load('exam.schoolClass', 'subject');

        $students = Student::with('user')
            ->where('class_id', $examSubject->exam->class_id)
            ->orderBy('roll_no')
            ->get();

        $existing = ExamResult::where('exam_subject_id', $examSubject->id)
            ->pluck('marks_obtained', 'student_id');

        return view('teacher.exams.marks', compact('examSubject', 'students', 'existing'));
    }

    public function storeMarks(Request $request, ExamSubject $examSubject)
    {
        $data = $request->validate([
            'marks' => ['required', 'array'],
            'marks.*' => ['nullable', 'numeric', 'min:0', 'max:'.$examSubject->full_marks],
        ]);

        foreach ($data['marks'] as $studentId => $marks) {
            if ($marks === null || $marks === '') {
                continue;
            }

            ExamResult::updateOrCreate(
                ['exam_subject_id' => $examSubject->id, 'student_id' => $studentId],
                [
                    'marks_obtained' => $marks,
                    'grade' => $marks >= $examSubject->pass_marks ? 'Pass' : 'Fail',
                ]
            );
        }

        return back()->with('status', 'মার্কস সংরক্ষণ করা হয়েছে।');
    }
}
