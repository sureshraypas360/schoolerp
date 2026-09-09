<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::user()->staff;
        $notices = Notice::where('school_id', $staff?->school_id)->latest('publish_date')->take(5)->get();
        $pendingCount = FeeInvoice::whereIn('status', ['unpaid', 'partial'])->count();

        return view('staff.dashboard', compact('staff', 'notices', 'pendingCount'));
    }
}
