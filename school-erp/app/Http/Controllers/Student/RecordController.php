<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function attendance()
    {
        $student = Auth::user()->student;
        $attendances = $student?->attendances()->latest('date')->paginate(30);

        return view('student.attendance', compact('attendances'));
    }

    public function fees()
    {
        $student = Auth::user()->student;
        $invoices = $student?->invoices()->with('feeType')->latest()->paginate(15);

        return view('student.fees', compact('invoices'));
    }

    public function results()
    {
        $student = Auth::user()->student;
        $results = $student?->results()->with('examSubject.subject', 'examSubject.exam')->latest()->paginate(20);

        return view('student.results', compact('results'));
    }

    public function facilities()
    {
        $student = Auth::user()->student;
        $bookIssues = $student?->bookIssues()->with('book')->latest()->get();
        $hostelAllocation = $student?->hostelAllocations()->whereNull('vacated_date')->with('room')->first();
        $transportAssignment = $student?->transportAssignments()->with('route')->latest()->first();

        return view('student.facilities', compact('bookIssues', 'hostelAllocation', 'transportAssignment'));
    }
}
