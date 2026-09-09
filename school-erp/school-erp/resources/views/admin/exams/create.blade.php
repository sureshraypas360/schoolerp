@extends('layouts.admin')
@section('page-title', 'নতুন পরীক্ষা')
@section('content')
<form method="POST" action="{{ route('admin.exams.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">ক্লাস</label>
        <select name="class_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->school->name }} - {{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="block text-sm font-medium mb-1">পরীক্ষার নাম</label>
        <input type="text" name="name" required class="w-full border rounded px-3 py-2" placeholder="যেমন: Half Yearly Exam"></div>
    <div><label class="block text-sm font-medium mb-1">শুরুর তারিখ</label>
        <input type="date" name="start_date" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">শেষের তারিখ</label>
        <input type="date" name="end_date" class="w-full border rounded px-3 py-2"></div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">তৈরি করুন</button>
</form>
@endsection
