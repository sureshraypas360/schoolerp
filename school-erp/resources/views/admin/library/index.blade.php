@extends('layouts.admin')
@section('page-title', 'লাইব্রেরি')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">নতুন বই যোগ করুন</h2>
        <form method="POST" action="{{ route('admin.library.books.store') }}" class="space-y-3">
            @csrf
            <select name="school_id" required class="w-full border rounded px-3 py-2">
                <option value="">স্কুল নির্বাচন করুন</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
            <input type="text" name="title" placeholder="বইয়ের নাম" required class="w-full border rounded px-3 py-2">
            <input type="text" name="author" placeholder="লেখক" class="w-full border rounded px-3 py-2">
            <input type="text" name="isbn" placeholder="ISBN (ঐচ্ছিক)" class="w-full border rounded px-3 py-2">
            <input type="number" name="total_copies" placeholder="মোট কপি" value="1" required class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">যোগ করুন</button>
        </form>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">বই ইস্যু করুন</h2>
        <form method="POST" action="{{ route('admin.library.issue') }}" class="space-y-3">
            @csrf
            <select name="book_id" required class="w-full border rounded px-3 py-2">
                <option value="">বই নির্বাচন করুন</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} উপলব্ধ)</option>
                @endforeach
            </select>
            <select name="student_id" required class="w-full border rounded px-3 py-2">
                <option value="">শিক্ষার্থী নির্বাচন করুন</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->admission_no }})</option>
                @endforeach
            </select>
            <input type="date" name="due_date" class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">ইস্যু করুন</button>
        </form>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto mb-6">
    <h2 class="font-semibold p-4 border-b">বই তালিকা</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">নাম</th><th class="p-3">লেখক</th><th class="p-3">মোট</th><th class="p-3">উপলব্ধ</th></tr></thead>
        <tbody>
        @foreach ($books as $book)
            <tr class="border-t">
                <td class="p-3">{{ $book->title }}</td>
                <td class="p-3">{{ $book->author }}</td>
                <td class="p-3">{{ $book->total_copies }}</td>
                <td class="p-3">{{ $book->available_copies }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <h2 class="font-semibold p-4 border-b">বর্তমানে ইস্যুকৃত বই</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">বই</th><th class="p-3">শিক্ষার্থী</th><th class="p-3">ইস্যু তারিখ</th><th class="p-3">শেষ তারিখ</th><th class="p-3">অ্যাকশন</th></tr></thead>
        <tbody>
        @foreach ($issues as $issue)
            <tr class="border-t">
                <td class="p-3">{{ $issue->book->title }}</td>
                <td class="p-3">{{ $issue->student->user->name }}</td>
                <td class="p-3">{{ $issue->issue_date->format('d M, Y') }}</td>
                <td class="p-3">{{ $issue->due_date?->format('d M, Y') }}</td>
                <td class="p-3">
                    <form action="{{ route('admin.library.return', $issue) }}" method="POST">
                        @csrf<button class="text-indigo-600">ফেরত নিন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
