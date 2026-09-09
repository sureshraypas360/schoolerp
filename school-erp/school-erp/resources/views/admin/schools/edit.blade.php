@extends('layouts.admin')

@section('page-title', 'স্কুল এডিট')

@section('content')
<form method="POST" action="{{ route('admin.schools.update', $school) }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name', $school->name) }}" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email', $school->email) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ফোন</label>
        <input type="text" name="phone" value="{{ old('phone', $school->phone) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ঠিকানা</label>
        <textarea name="address" class="w-full border rounded px-3 py-2">{{ old('address', $school->address) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">স্ট্যাটাস</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="active" @selected($school->status === 'active')>Active</option>
            <option value="inactive" @selected($school->status === 'inactive')>Inactive</option>
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">আপডেট করুন</button>
</form>
@endsection
