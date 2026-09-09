<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'school'])->latest()->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();

        return view('admin.teachers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'school_id' => ['required', 'exists:schools,id'],
            'employee_id' => ['required', 'string', 'unique:teachers,employee_id'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'joining_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'teacher',
                'phone' => $data['phone'] ?? null,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'school_id' => $data['school_id'],
                'employee_id' => $data['employee_id'],
                'qualification' => $data['qualification'] ?? null,
                'joining_date' => $data['joining_date'] ?? null,
                'salary' => $data['salary'] ?? null,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('status', 'শিক্ষক যোগ করা হয়েছে।');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        $schools = School::orderBy('name')->get();

        return view('admin.teachers.edit', compact('teacher', 'schools'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$teacher->user_id],
            'phone' => ['nullable', 'string', 'max:20'],
            'school_id' => ['required', 'exists:schools,id'],
            'employee_id' => ['required', 'string', 'unique:teachers,employee_id,'.$teacher->id],
            'qualification' => ['nullable', 'string', 'max:255'],
            'joining_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        DB::transaction(function () use ($data, $teacher) {
            $teacher->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'status' => $data['status'],
            ]);

            $teacher->update([
                'school_id' => $data['school_id'],
                'employee_id' => $data['employee_id'],
                'qualification' => $data['qualification'] ?? null,
                'joining_date' => $data['joining_date'] ?? null,
                'salary' => $data['salary'] ?? null,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('status', 'শিক্ষকের তথ্য আপডেট হয়েছে।');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user()->delete();
        $teacher->delete();

        return back()->with('status', 'শিক্ষক মুছে ফেলা হয়েছে।');
    }
}
