<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use Illuminate\Http\Request;

class FeeCollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = FeeInvoice::with(['student.user', 'feeType']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(20)->withQueryString();

        return view('staff.fees.index', compact('invoices'));
    }

    public function collect(Request $request, FeeInvoice $invoice)
    {
        $data = $request->validate([
            'paid_amount' => ['required', 'numeric', 'min:0'],
        ]);

        $newPaid = $invoice->paid_amount + $data['paid_amount'];
        $status = $newPaid >= $invoice->amount ? 'paid' : ($newPaid > 0 ? 'partial' : 'unpaid');

        $invoice->update([
            'paid_amount' => min($newPaid, $invoice->amount),
            'status' => $status,
            'paid_at' => $status === 'paid' ? now() : $invoice->paid_at,
            'collected_by' => $request->user()->id,
        ]);

        return back()->with('status', 'পেমেন্ট রেকর্ড করা হয়েছে।');
    }
}
