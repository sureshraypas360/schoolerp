@extends('layouts.admin')
@section('page-title', 'ক্লাস এডিট')
@section('content')
<form method="POST" action="{{ route('admin.classes.update', $class) }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-sm font-medium mb-1">স্কুল</label>
        <select name="school_id" required class="w-full border rounded px-3 py-2">
            @foreach ($schools as $school)
                <option value="{{ $school->id }}" @selected($class->school_id == $school->id)>{{ $school->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">ক্লাসের নাম</label>
        <input type="text" name="name" value="{{ old('name', $class->name) }}" required class="w-full border rounded px-3 py-2">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">আপডেট করুন</button>
</form>
@endsection
