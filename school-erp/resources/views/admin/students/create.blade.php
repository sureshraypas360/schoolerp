@extends('layouts.admin')
@section('page-title', 'নতুন ভর্তি')
@section('content')
<form method="POST" action="{{ route('admin.students.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div><label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">পাসওয়ার্ড</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($schools as $school)<option value="{{ $school->id }}">{{ $school->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">ক্লাস</label>
        <select name="class_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">সেকশন</label>
        <select name="section_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($sections as $section)<option value="{{ $section->id }}">{{ $section->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">ভর্তি নম্বর</label>
        <input type="text" name="admission_no" value="{{ old('admission_no') }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">রোল নম্বর</label>
        <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">অভিভাবকের নাম</label>
        <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">অভিভাবকের ফোন</label>
        <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">জন্ম তারিখ</label>
        <input type="date" name="dob" value="{{ old('dob') }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">লিঙ্গ</label>
        <select name="gender" class="w-full border rounded px-3 py-2">
            <option value="male">Male</option><option value="female">Female</option><option value="other">Other</option>
        </select></div>
    <div><label class="block text-sm font-medium mb-1">ভর্তির তারিখ</label>
        <input type="date" name="admission_date" value="{{ old('admission_date') }}" class="w-full border rounded px-3 py-2"></div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">ভর্তি করুন</button>
</form>
@endsection
