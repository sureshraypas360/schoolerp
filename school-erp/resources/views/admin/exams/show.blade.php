@extends('layouts.admin')
@section('page-title', 'পরীক্ষার বিস্তারিত')
@section('content')
<div class="bg-white rounded shadow p-4 mb-6">
    <h2 class="font-semibold text-lg">{{ $exam->name }}</h2>
    <p class="text-sm text-gray-500">ক্লাস: {{ $exam->schoolClass->name }} ({{ $exam->schoolClass->school->name }})</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-4">
        <h3 class="font-semibold mb-3">বিষয় যোগ করুন</h3>
        <form method="POST" action="{{ route('admin.exams.subjects.store', $exam) }}" class="space-y-3">
            @csrf
            <select name="subject_id" required class="w-full border rounded px-3 py-2">
                <option value="">বিষয় নির্বাচন করুন</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <input type="number" name="full_marks" placeholder="পূর্ণমান" value="100" required class="w-full border rounded px-3 py-2">
            <input type="number" name="pass_marks" placeholder="পাশ মার্ক" value="33" required class="w-full border rounded px-3 py-2">
            <input type="date" name="exam_date" class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">যোগ করুন</button>
        </form>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h3 class="font-semibold mb-3">পরীক্ষার বিষয় তালিকা</h3>
        <table class="w-full text-sm">
            <thead class="text-left border-b"><tr>
                <th class="py-2">বিষয়</th><th class="py-2">পূর্ণমান</th><th class="py-2">পাশ মার্ক</th><th class="py-2">তারিখ</th>
            </tr></thead>
            <tbody>
            @foreach ($exam->examSubjects as $es)
                <tr class="border-b">
                    <td class="py-2">{{ $es->subject->name }}</td>
                    <td class="py-2">{{ $es->full_marks }}</td>
                    <td class="py-2">{{ $es->pass_marks }}</td>
                    <td class="py-2">{{ $es->exam_date?->format('d M') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
