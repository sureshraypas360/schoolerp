@extends('layouts.admin')
@section('page-title', 'আইডি কার্ড')
@section('content')
<form method="GET" class="bg-white rounded shadow p-4 mb-6 flex gap-4 items-end no-print">
    <div class="flex-1">
        <label class="block text-sm font-medium mb-1">শিক্ষার্থী নির্বাচন করুন</label>
        <select name="student_id" onchange="this.form.submit()" class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>{{ $student->user->name }} ({{ $student->admission_no }})</option>
            @endforeach
        </select>
    </div>
</form>

@if ($selected)
<div class="mb-4 no-print">
    <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">প্রিন্ট করুন</button>
</div>

<div id="card" class="bg-white border-2 border-indigo-600 rounded-lg p-4 w-80">
    <h2 class="text-center font-bold text-indigo-700">{{ $selected->school->name }}</h2>
    <p class="text-center text-xs text-gray-500 mb-3">STUDENT ID CARD</p>
    <div class="text-sm space-y-1">
        <p><strong>নাম:</strong> {{ $selected->user->name }}</p>
        <p><strong>ভর্তি নং:</strong> {{ $selected->admission_no }}</p>
        <p><strong>ক্লাস:</strong> {{ $selected->schoolClass->name }} - {{ $selected->section->name }}</p>
        <p><strong>রোল:</strong> {{ $selected->roll_no }}</p>
        <p><strong>অভিভাবক:</strong> {{ $selected->guardian_name }}</p>
        <p><strong>ফোন:</strong> {{ $selected->guardian_phone }}</p>
    </div>
</div>

<style>
    @media print {
        .no-print, aside, header { display: none !important; }
        main { padding: 0 !important; }
        #card { border: 2px solid #333 !important; }
    }
</style>
@endif
@endsection
