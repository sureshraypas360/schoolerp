<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostelAllocation;
use App\Models\HostelRoom;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $rooms = HostelRoom::with('school')->withCount('activeAllocations')->latest()->get();
        $allocations = HostelAllocation::with(['room', 'student.user'])->whereNull('vacated_date')->latest()->get();
        $students = Student::with('user')->orderBy('admission_no')->get();
        $schools = School::orderBy('name')->get();

        return view('admin.hostel.index', compact('rooms', 'allocations', 'students', 'schools'));
    }

    public function storeRoom(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'room_no' => ['required', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        HostelRoom::create($data);

        return back()->with('status', 'রুম যোগ করা হয়েছে।');
    }

    public function allocate(Request $request)
    {
        $data = $request->validate([
            'hostel_room_id' => ['required', 'exists:hostel_rooms,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $room = HostelRoom::findOrFail($data['hostel_room_id']);

        if ($room->activeAllocations()->count() >= $room->capacity) {
            return back()->with('status', 'রুমটি পূর্ণ।');
        }

        HostelAllocation::create([
            'hostel_room_id' => $room->id,
            'student_id' => $data['student_id'],
            'allocated_date' => now(),
        ]);

        return back()->with('status', 'শিক্ষার্থীকে রুম বরাদ্দ করা হয়েছে।');
    }

    public function vacate(HostelAllocation $allocation)
    {
        $allocation->update(['vacated_date' => now()]);

        return back()->with('status', 'সিট খালি করা হয়েছে।');
    }
}
