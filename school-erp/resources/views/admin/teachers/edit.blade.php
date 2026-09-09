@extends('layouts.admin')
@section('page-title', 'শিক্ষক এডিট')
@section('content')
<form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf @method('PUT')
    <div><label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name', $teacher->user->name) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ফোন</label>
        <input type="text" name="phone" value="{{ old('phone', $teacher->user->phone) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            @foreach ($schools as $school)
                <option value="{{ $school->id }}" @selected($teacher->school_id == $school->id)>{{ $school->name }}</option>
            @endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">এমপ্লয়ি আইডি</label>
        <input type="text" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">যোগ্যতা</label>
        <input type="text" name="qualification" value="{{ old('qualification', $teacher->qualification) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">যোগদানের তারিখ</label>
        <input type="date" name="joining_date" value="{{ old('joining_date', $teacher->joining_date) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">বেতন</label>
        <input type="number" step="0.01" name="salary" value="{{ old('salary', $teacher->salary) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্ট্যাটাস</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="active" @selected($teacher->user->status === 'active')>Active</option>
            <option value="inactive" @selected($teacher->user->status === 'inactive')>Inactive</option>
        </select></div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">আপডেট করুন</button>
</form>
@endsection
