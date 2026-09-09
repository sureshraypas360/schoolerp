@extends('layouts.staff')
@section('page-title', 'ফি সংগ্রহ')
@section('content')
<form method="GET" class="bg-white rounded shadow p-4 mb-4">
    <select name="status" onchange="this.form.submit()" class="border rounded px-3 py-2">
        <option value="">সব</option>
        <option value="unpaid" @selected(request('status') === 'unpaid')>বকেয়া</option>
        <option value="partial" @selected(request('status') === 'partial')>আংশিক</option>
        <option value="paid" @selected(request('status') === 'paid')>পরিশোধিত</option>
    </select>
</form>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">শিক্ষার্থী</th><th class="p-3">ফি টাইপ</th><th class="p-3">মোট</th><th class="p-3">পরিশোধিত</th><th class="p-3">বকেয়া</th><th class="p-3">স্ট্যাটাস</th><th class="p-3">পেমেন্ট নিন</th>
        </tr></thead>
        <tbody>
        @foreach ($invoices as $invoice)
            <tr class="border-t">
                <td class="p-3">{{ $invoice->student->user->name }}</td>
                <td class="p-3">{{ $invoice->feeType->name }}</td>
                <td class="p-3">{{ number_format($invoice->amount, 2) }}</td>
                <td class="p-3">{{ number_format($invoice->paid_amount, 2) }}</td>
                <td class="p-3">{{ number_format($invoice->dueAmount(), 2) }}</td>
                <td class="p-3 capitalize">{{ $invoice->status }}</td>
                <td class="p-3">
                    @if ($invoice->status !== 'paid')
                        <form action="{{ route('staff.fees.collect', $invoice) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="number" step="0.01" name="paid_amount" max="{{ $invoice->dueAmount() }}" required class="border rounded px-2 py-1 w-24">
                            <button class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">জমা নিন</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $invoices->links() }}</div>
@endsection
