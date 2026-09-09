@extends('layouts.admin')
@section('page-title', 'স্টাফ এডিট')
@section('content')
<form method="POST" action="{{ route('admin.staff.update', $staff) }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf @method('PUT')
    <div><label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name', $staff->user->name) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email', $staff->user->email) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            @foreach ($schools as $school)<option value="{{ $school->id }}" @selected($staff->school_id == $school->id)>{{ $school->name }}</option>@endforeach
        </select></div>
    <div><label class="block text-sm font-medium mb-1">এমপ্লয়ি আইডি</label>
        <input type="text" name="employee_id" value="{{ old('employee_id', $staff->employee_id) }}" required class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">পদবি</label>
        <input type="text" name="designation" value="{{ old('designation', $staff->designation) }}" class="w-full border rounded px-3 py-2"></div>
    <div><label class="block text-sm font-medium mb-1">স্ট্যাটাস</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="active" @selected($staff->user->status === 'active')>Active</option>
            <option value="inactive" @selected($staff->user->status === 'inactive')>Inactive</option>
        </select></div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">আপডেট করুন</button>
</form>
@endsection
