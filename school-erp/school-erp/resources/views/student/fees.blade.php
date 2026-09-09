@extends('layouts.student')
@section('page-title', 'আমার ফি')
@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">ফি টাইপ</th><th class="p-3">পরিমাণ</th><th class="p-3">পরিশোধিত</th><th class="p-3">বকেয়া</th><th class="p-3">শেষ তারিখ</th><th class="p-3">স্ট্যাটাস</th>
        </tr></thead>
        <tbody>
        @forelse ($invoices as $invoice)
            <tr class="border-t">
                <td class="p-3">{{ $invoice->feeType->name }}</td>
                <td class="p-3">{{ number_format($invoice->amount, 2) }}</td>
                <td class="p-3">{{ number_format($invoice->paid_amount, 2) }}</td>
                <td class="p-3">{{ number_format($invoice->dueAmount(), 2) }}</td>
                <td class="p-3">{{ $invoice->due_date?->format('d M, Y') }}</td>
                <td class="p-3 capitalize">{{ $invoice->status }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-3 text-gray-500">কোনো ইনভয়েস নেই।</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $invoices?->links() }}</div>
@endsection
