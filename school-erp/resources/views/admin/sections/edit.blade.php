@extends('layouts.admin')
@section('page-title', 'সেকশন এডিট')
@section('content')
<form method="POST" action="{{ route('admin.sections.update', $section) }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-sm font-medium mb-1">ক্লাস</label>
        <select name="class_id" required class="w-full border rounded px-3 py-2">
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" @selected($section->class_id == $class->id)>{{ $class->school->name }} - {{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">সেকশনের নাম</label>
        <input type="text" name="name" value="{{ old('name', $section->name) }}" required class="w-full border rounded px-3 py-2">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">আপডেট করুন</button>
</form>
@endsection
