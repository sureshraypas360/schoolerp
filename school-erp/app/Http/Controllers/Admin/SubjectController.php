<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('schoolClass.school')->latest()->paginate(15);

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = SchoolClass::with('school')->orderBy('name')->get();

        return view('admin.subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:30'],
        ]);

        $class = SchoolClass::findOrFail($data['class_id']);
        $data['school_id'] = $class->school_id;

        Subject::create($data);

        return redirect()->route('admin.subjects.index')->with('status', 'বিষয় যোগ করা হয়েছে।');
    }

    public function edit(Subject $subject)
    {
        $classes = SchoolClass::with('school')->orderBy('name')->get();

        return view('admin.subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:30'],
        ]);

        $class = SchoolClass::findOrFail($data['class_id']);
        $data['school_id'] = $class->school_id;

        $subject->update($data);

        return redirect()->route('admin.subjects.index')->with('status', 'বিষয় আপডেট হয়েছে।');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return back()->with('status', 'বিষয় মুছে ফেলা হয়েছে।');
    }
}
