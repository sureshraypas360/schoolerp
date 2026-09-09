<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::withCount(['classes', 'teachers', 'students'])->latest()->paginate(15);

        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        School::create($data);

        return redirect()->route('admin.schools.index')->with('status', 'স্কুল যোগ করা হয়েছে।');
    }

    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $school->update($data);

        return redirect()->route('admin.schools.index')->with('status', 'স্কুল আপডেট হয়েছে।');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return back()->with('status', 'স্কুল মুছে ফেলা হয়েছে।');
    }
}
