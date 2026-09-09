<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('schoolClass.school')->withCount('students')->latest()->paginate(15);

        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        $classes = SchoolClass::with('school')->orderBy('name')->get();

        return view('admin.sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'name' => ['required', 'string', 'max:50'],
        ]);

        Section::create($data);

        return redirect()->route('admin.sections.index')->with('status', 'সেকশন যোগ করা হয়েছে।');
    }

    public function edit(Section $section)
    {
        $classes = SchoolClass::with('school')->orderBy('name')->get();

        return view('admin.sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'name' => ['required', 'string', 'max:50'],
        ]);

        $section->update($data);

        return redirect()->route('admin.sections.index')->with('status', 'সেকশন আপডেট হয়েছে।');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return back()->with('status', 'সেকশন মুছে ফেলা হয়েছে।');
    }
}
