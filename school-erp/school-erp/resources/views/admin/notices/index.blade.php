@extends('layouts.admin')
@section('page-title', 'নোটিশ')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">নতুন নোটিশ</h2>
        <form method="POST" action="{{ route('admin.notices.store') }}" class="space-y-3">
            @csrf
            <select name="school_id" required class="w-full border rounded px-3 py-2">
                <option value="">স্কুল নির্বাচন করুন</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
            <input type="text" name="title" placeholder="শিরোনাম" required class="w-full border rounded px-3 py-2">
            <textarea name="description" placeholder="বিস্তারিত" class="w-full border rounded px-3 py-2"></textarea>
            <input type="date" name="publish_date" required class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">প্রকাশ করুন</button>
        </form>
    </div>
    <div class="lg:col-span-2 bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">সকল নোটিশ</h2>
        @foreach ($notices as $notice)
            <div class="border-b py-3 flex justify-between items-start">
                <div>
                    <p class="font-medium">{{ $notice->title }}</p>
                    <p class="text-sm text-gray-500">{{ $notice->publish_date->format('d M, Y') }} — {{ $notice->publisher->name }}</p>
                    <p class="text-sm mt-1">{{ $notice->description }}</p>
                </div>
                <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('নিশ্চিত?')">
                    @csrf @method('DELETE')<button class="text-red-600 text-sm">মুছুন</button>
                </form>
            </div>
        @endforeach
        <div class="mt-4">{{ $notices->links() }}</div>
    </div>
</div>
@endsection
