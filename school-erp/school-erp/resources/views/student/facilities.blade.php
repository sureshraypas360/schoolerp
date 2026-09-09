@extends('layouts.student')
@section('page-title', 'সুবিধাসমূহ')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">লাইব্রেরি</h2>
        @forelse ($bookIssues as $issue)
            <div class="border-b py-2 text-sm">
                <p class="font-medium">{{ $issue->book->title }}</p>
                <p class="text-gray-500">স্ট্যাটাস: {{ $issue->status }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-sm">কোনো বই ইস্যু নেই।</p>
        @endforelse
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">হোস্টেল</h2>
        @if ($hostelAllocation)
            <p class="text-sm">রুম: {{ $hostelAllocation->room->room_no }}</p>
            <p class="text-sm text-gray-500">বরাদ্দের তারিখ: {{ $hostelAllocation->allocated_date->format('d M, Y') }}</p>
        @else
            <p class="text-gray-500 text-sm">হোস্টেলে নেই।</p>
        @endif
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">ট্রান্সপোর্ট</h2>
        @if ($transportAssignment)
            <p class="text-sm">রুট: {{ $transportAssignment->route->route_name }}</p>
            <p class="text-sm text-gray-500">ভাড়া: {{ number_format($transportAssignment->route->fare, 2) }}</p>
        @else
            <p class="text-gray-500 text-sm">কোনো রুটে যুক্ত নেই।</p>
        @endif
    </div>
</div>
@endsection
