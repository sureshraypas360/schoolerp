@extends('layouts.admin')
@section('page-title', 'নতুন ক্লাস')
@section('content')
<form method="POST" action="{{ route('admin.classes.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($schools as $school)
                <option value="{{ $school->id }}" @selected(old('school_id') == $school->id)>{{ $school->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ক্লাসের নাম</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2" placeholder="যেমন: Class 6">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">সংরক্ষণ করুন</button>
</form>
@endsection
