<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('school')->withCount('sections')->latest()->paginate(15);

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();

        return view('admin.classes.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        SchoolClass::create($data);

        return redirect()->route('admin.classes.index')->with('status', 'ক্লাস যোগ করা হয়েছে।');
    }

    public function edit(SchoolClass $class)
    {
        $schools = School::orderBy('name')->get();

        return view('admin.classes.edit', ['class' => $class, 'schools' => $schools]);
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        $class->update($data);

        return redirect()->route('admin.classes.index')->with('status', 'ক্লাস আপডেট হয়েছে।');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return back()->with('status', 'ক্লাস মুছে ফেলা হয়েছে।');
    }
}
