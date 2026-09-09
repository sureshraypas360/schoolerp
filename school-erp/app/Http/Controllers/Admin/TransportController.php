<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentTransport;
use App\Models\TransportRoute;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $routes = TransportRoute::with('school')->withCount('assignments')->latest()->get();
        $assignments = StudentTransport::with(['route', 'student.user'])->latest()->get();
        $students = Student::with('user')->orderBy('admission_no')->get();
        $schools = School::orderBy('name')->get();

        return view('admin.transport.index', compact('routes', 'assignments', 'students', 'schools'));
    }

    public function storeRoute(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'route_name' => ['required', 'string', 'max:255'],
            'vehicle_no' => ['nullable', 'string', 'max:50'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'driver_phone' => ['nullable', 'string', 'max:20'],
            'fare' => ['required', 'numeric', 'min:0'],
        ]);

        TransportRoute::create($data);

        return back()->with('status', 'রুট যোগ করা হয়েছে।');
    }

    public function assign(Request $request)
    {
        $data = $request->validate([
            'transport_route_id' => ['required', 'exists:transport_routes,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $data['assigned_date'] = now();

        StudentTransport::create($data);

        return back()->with('status', 'শিক্ষার্থীকে রুটে যুক্ত করা হয়েছে।');
    }

    public function unassign(StudentTransport $assignment)
    {
        $assignment->delete();

        return back()->with('status', 'রুট থেকে সরানো হয়েছে।');
    }
}
