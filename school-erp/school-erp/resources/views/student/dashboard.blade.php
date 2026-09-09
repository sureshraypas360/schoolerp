@extends('layouts.student')
@section('page-title', 'ড্যাশবোর্ড')
@section('content')
<div class="bg-white rounded shadow p-4 mb-6">
    <h2 class="font-semibold mb-2">স্বাগতম, {{ auth()->user()->name }}</h2>
    <p class="text-sm text-gray-500">
        ভর্তি নং: {{ $student?->admission_no }} |
        ক্লাস: {{ $student?->schoolClass?->name }} |
        সেকশন: {{ $student?->section?->name }}
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">উপস্থিতি সারসংক্ষেপ</h2>
        @forelse ($attendanceSummary as $status => $count)
            <div class="flex justify-between border-b py-1 text-sm capitalize">
                <span>{{ $status }}</span><span>{{ $count }}</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">কোনো তথ্য নেই।</p>
        @endforelse
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">সাম্প্রতিক নোটিশ</h2>
        @forelse ($notices as $notice)
            <div class="border-b py-2">
                <p class="font-medium">{{ $notice->title }}</p>
                <p class="text-sm text-gray-500">{{ $notice->publish_date->format('d M, Y') }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-sm">কোনো নোটিশ নেই।</p>
        @endforelse
    </div>
</div>
@endsection
