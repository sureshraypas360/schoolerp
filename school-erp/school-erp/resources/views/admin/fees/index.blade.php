@extends('layouts.admin')
@section('page-title', 'ফি ম্যানেজমেন্ট')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">নতুন ফি টাইপ</h2>
        <form method="POST" action="{{ route('admin.fees.types.store') }}" class="space-y-3">
            @csrf
            <select name="school_id" required class="w-full border rounded px-3 py-2">
                <option value="">স্কুল নির্বাচন করুন</option>
                @foreach ($feeTypes->pluck('school')->unique('id') as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
            <input type="text" name="name" placeholder="যেমন: Tuition Fee" required class="w-full border rounded px-3 py-2">
            <input type="number" step="0.01" name="amount" placeholder="পরিমাণ" required class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">যোগ করুন</button>
        </form>
        <div class="mt-4 space-y-1 text-sm">
            @foreach ($feeTypes as $type)
                <div class="flex justify-between border-b py-1">
                    <span>{{ $type->name }} ({{ $type->school->name }})</span>
                    <span>{{ number_format($type->amount, 2) }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">ইনভয়েস তৈরি করুন</h2>
        <a href="{{ route('admin.fees.invoices.create') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন ইনভয়েস</a>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">শিক্ষার্থী</th><th class="p-3">ফি টাইপ</th><th class="p-3">পরিমাণ</th><th class="p-3">পরিশোধিত</th><th class="p-3">স্ট্যাটাস</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($invoices as $invoice)
            <tr class="border-t">
                <td class="p-3">{{ $invoice->student->user->name }}</td>
                <td class="p-3">{{ $invoice->feeType->name }}</td>
                <td class="p-3">{{ number_format($invoice->amount, 2) }}</td>
                <td class="p-3">{{ number_format($invoice->paid_amount, 2) }}</td>
                <td class="p-3 capitalize">{{ $invoice->status }}</td>
                <td class="p-3">
                    <form action="{{ route('admin.fees.invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $invoices->links() }}</div>
@endsection
