@extends('layouts.teacher')
@section('page-title', 'উপস্থিতি নিন')
@section('content')
<form method="GET" class="bg-white rounded shadow p-4 mb-4 flex gap-4 items-end">
    <div>
        <label class="block text-sm font-medium mb-1">সেকশন</label>
        <select name="section_id" onchange="this.form.submit()" class="border rounded px-3 py-2">
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" @selected($sectionId == $section->id)>{{ $section->schoolClass->name }} - {{ $section->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">তারিখ</label>
        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="border rounded px-3 py-2">
    </div>
</form>

@if ($students->isNotEmpty())
<form method="POST" action="{{ route('teacher.attendance.store') }}" class="bg-white rounded shadow p-4">
    @csrf
    <input type="hidden" name="section_id" value="{{ $sectionId }}">
    <input type="hidden" name="date" value="{{ $date }}">
    <table class="w-full text-sm mb-4">
        <thead class="text-left border-b"><tr>
            <th class="py-2">রোল</th><th class="py-2">নাম</th><th class="py-2">উপস্থিতি</th>
        </tr></thead>
        <tbody>
        @foreach ($students as $student)
            <tr class="border-b">
                <td class="py-2">{{ $student->roll_no }}</td>
                <td class="py-2">{{ $student->user->name }}</td>
                <td class="py-2">
                    <select name="statuses[{{ $student->id }}]" class="border rounded px-2 py-1">
                        @php $current = $existing[$student->id] ?? 'present'; @endphp
                        <option value="present" @selected($current === 'present')>উপস্থিত</option>
                        <option value="absent" @selected($current === 'absent')>অনুপস্থিত</option>
                        <option value="late" @selected($current === 'late')>বিলম্বে</option>
                        <option value="leave" @selected($current === 'leave')>ছুটি</option>
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">সংরক্ষণ করুন</button>
</form>
@else
    <p class="text-gray-500">এই সেকশনে কোনো শিক্ষার্থী নেই।</p>
@endif
@endsection
