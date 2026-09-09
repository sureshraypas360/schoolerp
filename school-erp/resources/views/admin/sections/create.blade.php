@extends('layouts.admin')
@section('page-title', 'নতুন সেকশন')
@section('content')
<form method="POST" action="{{ route('admin.sections.store') }}" class="bg-white rounded shadow p-6 max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">ক্লাস</label>
        <select name="class_id" required class="w-full border rounded px-3 py-2">
            <option value="">নির্বাচন করুন</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>{{ $class->school->name }} - {{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">সেকশনের নাম</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2" placeholder="যেমন: A">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">সংরক্ষণ করুন</button>
</form>
@endsection
