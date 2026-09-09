@extends('layouts.teacher')
@section('page-title', 'হোমওয়ার্ক')
@section('content')
<div class="bg-white rounded shadow p-4 mb-6">
    <h2 class="font-semibold mb-3">নতুন হোমওয়ার্ক দিন</h2>
    <form method="POST" action="{{ route('teacher.homework.store') }}" class="space-y-3 max-w-lg">
        @csrf
        <select name="subject_id" required class="w-full border rounded px-3 py-2">
            <option value="">বিষয় নির্বাচন করুন</option>
            @foreach ($teacher?->subjects ?? [] as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
        <select name="section_id" required class="w-full border rounded px-3 py-2">
            <option value="">সেকশন নির্বাচন করুন</option>
            @foreach ($teacher?->subjects ?? [] as $subject)
                <option value="{{ $subject->pivot->section_id }}">{{ $subject->schoolClass->name }} - (সেকশন আইডি: {{ $subject->pivot->section_id }})</option>
            @endforeach
        </select>
        <input type="text" name="title" placeholder="শিরোনাম" required class="w-full border rounded px-3 py-2">
        <textarea name="description" placeholder="বিস্তারিত" class="w-full border rounded px-3 py-2"></textarea>
        <input type="date" name="due_date" class="w-full border rounded px-3 py-2">
        <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">দিন</button>
    </form>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">শিরোনাম</th><th class="p-3">বিষয়</th><th class="p-3">শেষ তারিখ</th><th class="p-3">অ্যাকশন</th></tr></thead>
        <tbody>
        @foreach ($homeworks as $homework)
            <tr class="border-t">
                <td class="p-3">{{ $homework->title }}</td>
                <td class="p-3">{{ $homework->subject->name }}</td>
                <td class="p-3">{{ $homework->due_date?->format('d M, Y') }}</td>
                <td class="p-3">
                    <form action="{{ route('teacher.homework.destroy', $homework) }}" method="POST" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
