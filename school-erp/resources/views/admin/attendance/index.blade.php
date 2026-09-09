@extends('layouts.admin')
@section('page-title', 'উপস্থিতি রিপোর্ট')
@section('content')
<form method="GET" class="bg-white rounded shadow p-4 mb-4 flex gap-4 items-end">
    <div>
        <label class="block text-sm font-medium mb-1">সেকশন</label>
        <select name="section_id" class="border rounded px-3 py-2">
            <option value="">সব</option>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" @selected(request('section_id') == $section->id)>{{ $section->schoolClass->name }} - {{ $section->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">তারিখ</label>
        <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">ফিল্টার</button>
</form>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">শিক্ষার্থী</th><th class="p-3">সেকশন</th><th class="p-3">তারিখ</th><th class="p-3">স্ট্যাটাস</th>
        </tr></thead>
        <tbody>
        @foreach ($attendances as $attendance)
            <tr class="border-t">
                <td class="p-3">{{ $attendance->student->user->name }}</td>
                <td class="p-3">{{ $attendance->section->schoolClass->name }} - {{ $attendance->section->name }}</td>
                <td class="p-3">{{ $attendance->date->format('d M, Y') }}</td>
                <td class="p-3 capitalize">{{ $attendance->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $attendances->links() }}</div>
@endsection
