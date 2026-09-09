@extends('layouts.teacher')
@section('page-title', 'মার্কস দিন')
@section('content')
<div class="bg-white rounded shadow p-4 mb-4">
    <h2 class="font-semibold">{{ $examSubject->exam->name }} — {{ $examSubject->subject->name }}</h2>
    <p class="text-sm text-gray-500">পূর্ণমান: {{ $examSubject->full_marks }}, পাশ মার্ক: {{ $examSubject->pass_marks }}</p>
</div>
<form method="POST" action="{{ route('teacher.exams.marks.store', $examSubject) }}" class="bg-white rounded shadow p-4">
    @csrf
    <table class="w-full text-sm mb-4">
        <thead class="text-left border-b"><tr>
            <th class="py-2">রোল</th><th class="py-2">নাম</th><th class="py-2">মার্কস</th>
        </tr></thead>
        <tbody>
        @foreach ($students as $student)
            <tr class="border-b">
                <td class="py-2">{{ $student->roll_no }}</td>
                <td class="py-2">{{ $student->user->name }}</td>
                <td class="py-2">
                    <input type="number" step="0.01" min="0" max="{{ $examSubject->full_marks }}"
                        name="marks[{{ $student->id }}]" value="{{ $existing[$student->id] ?? '' }}"
                        class="border rounded px-2 py-1 w-24">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">সংরক্ষণ করুন</button>
</form>
@endsection
