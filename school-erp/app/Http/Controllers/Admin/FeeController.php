<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use App\Models\FeeType;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::with('school')->latest()->get();
        $invoices = FeeInvoice::with(['student.user', 'feeType'])->latest()->paginate(15);

        return view('admin.fees.index', compact('feeTypes', 'invoices'));
    }

    public function storeType(Request $request)
    {
        $data = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        FeeType::create($data);

        return back()->with('status', 'ফি টাইপ যোগ করা হয়েছে।');
    }

    public function createInvoice()
    {
        $students = Student::with('user')->orderBy('admission_no')->get();
        $feeTypes = FeeType::orderBy('name')->get();

        return view('admin.fees.create-invoice', compact('students', 'feeTypes'));
    }

    public function storeInvoice(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'fee_type_id' => ['required', 'exists:fee_types,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
        ]);

        FeeInvoice::create($data);

        return redirect()->route('admin.fees.index')->with('status', 'ইনভয়েস তৈরি করা হয়েছে।');
    }

    public function destroyInvoice(FeeInvoice $invoice)
    {
        $invoice->delete();

        return back()->with('status', 'ইনভয়েস মুছে ফেলা হয়েছে।');
    }
}
