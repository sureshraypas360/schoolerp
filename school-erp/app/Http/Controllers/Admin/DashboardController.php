<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use App\Models\Notice;
use App\Models\School;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'schools' => School::count(),
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'staff' => Staff::count(),
            'due_fees' => FeeInvoice::whereIn('status', ['unpaid', 'partial'])->sum('amount')
                - FeeInvoice::whereIn('status', ['unpaid', 'partial'])->sum('paid_amount'),
        ];

        $notices = Notice::latest('publish_date')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'notices'));
    }
}
