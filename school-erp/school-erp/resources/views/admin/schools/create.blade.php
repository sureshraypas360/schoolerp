@extends('layouts.admin')

@section('page-title', 'নতুন স্কুল')

@section('content')
<form method="POST" action="{{ route('admin.schools.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">নাম</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ইমেইল</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ফোন</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ঠিকানা</label>
        <textarea name="address" class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">সংরক্ষণ করুন</button>
</form>
@endsection
