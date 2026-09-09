@extends('layouts.admin')
@section('page-title', 'হোস্টেল')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">নতুন রুম যোগ করুন</h2>
        <form method="POST" action="{{ route('admin.hostel.rooms.store') }}" class="space-y-3">
            @csrf
            <select name="school_id" required class="w-full border rounded px-3 py-2">
                <option value="">স্কুল নির্বাচন করুন</option>
                @foreach ($schools as $school)<option value="{{ $school->id }}">{{ $school->name }}</option>@endforeach
            </select>
            <input type="text" name="room_no" placeholder="রুম নম্বর" required class="w-full border rounded px-3 py-2">
            <input type="number" name="capacity" placeholder="ধারণক্ষমতা" value="1" required class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">যোগ করুন</button>
        </form>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">শিক্ষার্থীকে রুম বরাদ্দ করুন</h2>
        <form method="POST" action="{{ route('admin.hostel.allocate') }}" class="space-y-3">
            @csrf
            <select name="hostel_room_id" required class="w-full border rounded px-3 py-2">
                <option value="">রুম নির্বাচন করুন</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_no }} ({{ $room->active_allocations_count }}/{{ $room->capacity }})</option>
                @endforeach
            </select>
            <select name="student_id" required class="w-full border rounded px-3 py-2">
                <option value="">শিক্ষার্থী নির্বাচন করুন</option>
                @foreach ($students as $student)<option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->admission_no }})</option>@endforeach
            </select>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">বরাদ্দ করুন</button>
        </form>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto mb-6">
    <h2 class="font-semibold p-4 border-b">রুম তালিকা</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">রুম নং</th><th class="p-3">স্কুল</th><th class="p-3">ধারণক্ষমতা</th><th class="p-3">বর্তমান বাসিন্দা</th></tr></thead>
        <tbody>
        @foreach ($rooms as $room)
            <tr class="border-t">
                <td class="p-3">{{ $room->room_no }}</td>
                <td class="p-3">{{ $room->school->name }}</td>
                <td class="p-3">{{ $room->capacity }}</td>
                <td class="p-3">{{ $room->active_allocations_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <h2 class="font-semibold p-4 border-b">বর্তমান বরাদ্দ</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">শিক্ষার্থী</th><th class="p-3">রুম</th><th class="p-3">তারিখ</th><th class="p-3">অ্যাকশন</th></tr></thead>
        <tbody>
        @foreach ($allocations as $allocation)
            <tr class="border-t">
                <td class="p-3">{{ $allocation->student->user->name }}</td>
                <td class="p-3">{{ $allocation->room->room_no }}</td>
                <td class="p-3">{{ $allocation->allocated_date->format('d M, Y') }}</td>
                <td class="p-3">
                    <form action="{{ route('admin.hostel.vacate', $allocation) }}" method="POST">
                        @csrf<button class="text-red-600">খালি করুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
