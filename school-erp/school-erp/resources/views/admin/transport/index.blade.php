@extends('layouts.admin')
@section('page-title', 'ট্রান্সপোর্ট')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">নতুন রুট যোগ করুন</h2>
        <form method="POST" action="{{ route('admin.transport.routes.store') }}" class="space-y-3">
            @csrf
            <select name="school_id" required class="w-full border rounded px-3 py-2">
                <option value="">স্কুল নির্বাচন করুন</option>
                @foreach ($schools as $school)<option value="{{ $school->id }}">{{ $school->name }}</option>@endforeach
            </select>
            <input type="text" name="route_name" placeholder="রুটের নাম" required class="w-full border rounded px-3 py-2">
            <input type="text" name="vehicle_no" placeholder="গাড়ির নম্বর" class="w-full border rounded px-3 py-2">
            <input type="text" name="driver_name" placeholder="ড্রাইভারের নাম" class="w-full border rounded px-3 py-2">
            <input type="text" name="driver_phone" placeholder="ড্রাইভারের ফোন" class="w-full border rounded px-3 py-2">
            <input type="number" step="0.01" name="fare" placeholder="ভাড়া" required class="w-full border rounded px-3 py-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">যোগ করুন</button>
        </form>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">শিক্ষার্থীকে রুটে যুক্ত করুন</h2>
        <form method="POST" action="{{ route('admin.transport.assign') }}" class="space-y-3">
            @csrf
            <select name="transport_route_id" required class="w-full border rounded px-3 py-2">
                <option value="">রুট নির্বাচন করুন</option>
                @foreach ($routes as $route)<option value="{{ $route->id }}">{{ $route->route_name }}</option>@endforeach
            </select>
            <select name="student_id" required class="w-full border rounded px-3 py-2">
                <option value="">শিক্ষার্থী নির্বাচন করুন</option>
                @foreach ($students as $student)<option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->admission_no }})</option>@endforeach
            </select>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">যুক্ত করুন</button>
        </form>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto mb-6">
    <h2 class="font-semibold p-4 border-b">রুট তালিকা</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">রুট</th><th class="p-3">গাড়ি</th><th class="p-3">ড্রাইভার</th><th class="p-3">ভাড়া</th><th class="p-3">শিক্ষার্থী সংখ্যা</th></tr></thead>
        <tbody>
        @foreach ($routes as $route)
            <tr class="border-t">
                <td class="p-3">{{ $route->route_name }}</td>
                <td class="p-3">{{ $route->vehicle_no }}</td>
                <td class="p-3">{{ $route->driver_name }} ({{ $route->driver_phone }})</td>
                <td class="p-3">{{ number_format($route->fare, 2) }}</td>
                <td class="p-3">{{ $route->assignments_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <h2 class="font-semibold p-4 border-b">শিক্ষার্থী তালিকা (রুট অনুযায়ী)</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">শিক্ষার্থী</th><th class="p-3">রুট</th><th class="p-3">অ্যাকশন</th></tr></thead>
        <tbody>
        @foreach ($assignments as $assignment)
            <tr class="border-t">
                <td class="p-3">{{ $assignment->student->user->name }}</td>
                <td class="p-3">{{ $assignment->route->route_name }}</td>
                <td class="p-3">
                    <form action="{{ route('admin.transport.unassign', $assignment) }}" method="POST">
                        @csrf<button class="text-red-600">সরান</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
