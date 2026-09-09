<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'school', 'schoolClass', 'section'])->latest()->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->get();
        $sections = Section::orderBy('name')->get();

        return view('admin.students.create', compact('schools', 'classes', 'sections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'school_id' => ['required', 'exists:schools,id'],
            'class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'admission_no' => ['required', 'string', 'unique:students,admission_no'],
            'roll_no' => ['nullable', 'string', 'max:20'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:20'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'admission_date' => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'school_id' => $data['school_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'admission_no' => $data['admission_no'],
                'roll_no' => $data['roll_no'] ?? null,
                'guardian_name' => $data['guardian_name'] ?? null,
                'guardian_phone' => $data['guardian_phone'] ?? null,
                'dob' => $data['dob'] ?? null,
                'gender' => $data['gender'] ?? null,
                'admission_date' => $data['admission_date'] ?? null,
            ]);
        });

        return redirect()->route('admin.students.index')->with('status', 'শিক্ষার্থী ভর্তি করা হয়েছে।');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $schools = School::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->get();
        $sections = Section::orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'schools', 'classes', 'sections'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$student->user_id],
            'school_id' => ['required', 'exists:schools,id'],
            'class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'admission_no' => ['required', 'string', 'unique:students,admission_no,'.$student->id],
            'roll_no' => ['nullable', 'string', 'max:20'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        DB::transaction(function () use ($data, $student) {
            $student->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $data['status'],
            ]);

            $student->update([
                'school_id' => $data['school_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'admission_no' => $data['admission_no'],
                'roll_no' => $data['roll_no'] ?? null,
                'guardian_name' => $data['guardian_name'] ?? null,
                'guardian_phone' => $data['guardian_phone'] ?? null,
            ]);
        });

        return redirect()->route('admin.students.index')->with('status', 'শিক্ষার্থীর তথ্য আপডেট হয়েছে।');
    }

    public function destroy(Student $student)
    {
        $student->user()->delete();
        $student->delete();

        return back()->with('status', 'শিক্ষার্থী মুছে ফেলা হয়েছে।');
    }
}
