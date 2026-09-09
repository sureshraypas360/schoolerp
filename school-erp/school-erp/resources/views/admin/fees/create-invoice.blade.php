@extends('layouts.admin')
@section('page-title', 'নতুন ইনভয়েস')
@section('content')
<form method="POST" action="{{ route('admin.fees.invoices.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">শিক্ষার্থী</label>
        <select name="student_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->admission_no }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ফি টাইপ</label>
        <select name="fee_type_id" id="fee_type_id" required class="w-full border rounded px-3 py-2" onchange="document.getElementById('amount').value = this.options[this.selectedIndex].dataset.amount || ''">
            <option value="">নির্বাচন করুন</option>
            @foreach ($feeTypes as $type)
                <option value="{{ $type->id }}" data-amount="{{ $type->amount }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">পরিমাণ</label>
        <input type="number" step="0.01" id="amount" name="amount" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">শেষ তারিখ</label>
        <input type="date" name="due_date" class="w-full border rounded px-3 py-2">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">ইনভয়েস তৈরি করুন</button>
</form>
@endsection
