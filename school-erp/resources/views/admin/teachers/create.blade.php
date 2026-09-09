@extends('layouts.admin')
@section('page-title', 'নতুন শিক্ষক')
@section('content')
<form method="POST" action="{{ route('admin.teachers.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div><label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">পাসওয়ার্ড</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ফোন</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($schools as $school)
                <option value="{{ $school->id }}" @selected(old('school_id') == $school->id)>{{ $school->name }}</option>
            @endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">এমপ্লয়ি আইডি</label>
        <input type="text" name="employee_id" value="{{ old('employee_id') }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">যোগ্যতা</label>
        <input type="text" name="qualification" value="{{ old('qualification') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">যোগদানের তারিখ</label>
        <input type="date" name="joining_date" value="{{ old('joining_date') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">বেতন</label>
        <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" class="w-full border rounded px-3 py-2"></div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">সংরক্ষণ করুন</button>
</form>
@endsection
