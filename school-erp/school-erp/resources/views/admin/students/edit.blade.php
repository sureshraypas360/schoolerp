@extends('layouts.admin')
@section('page-title', 'শিক্ষার্থী এডিট')
@section('content')
<form method="POST" action="{{ route('admin.students.update', $student) }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf @method('PUT')
    <div><label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name', $student->user->name) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email', $student->user->email) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            @foreach ($schools as $school)<option value="{{ $school->id }}" @selected($student->school_id == $school->id)>{{ $school->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">ক্লাস</label>
        <select name="class_id" required class="w-full border rounded px-3 py-2">
            @foreach ($classes as $class)<option value="{{ $class->id }}" @selected($student->class_id == $class->id)>{{ $class->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">সেকশন</label>
        <select name="section_id" required class="w-full border rounded px-3 py-2">
            @foreach ($sections as $section)<option value="{{ $section->id }}" @selected($student->section_id == $section->id)>{{ $section->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">ভর্তি নম্বর</label>
        <input type="text" name="admission_no" value="{{ old('admission_no', $student->admission_no) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">রোল নম্বর</label>
        <input type="text" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">অভিভাবকের নাম</label>
        <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">অভিভাবকের ফোন</label>
        <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্ট্যাটাস</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="active" @selected($student->user->status === 'active')>Active</option>
            <option value="inactive" @selected($student->user->status === 'inactive')>Inactive</option>
        </select></div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">আপডেট করুন</button>
</form>
@endsection
