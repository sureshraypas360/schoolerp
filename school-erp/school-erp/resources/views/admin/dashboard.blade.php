@extends('layouts.admin')

@section('page-title', 'ড্যাশবোর্ড')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded shadow p-4">
        <p class="text-gray-500 text-sm">স্কুল</p>
        <p class="text-2xl font-bold">{{ $stats['schools'] }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-gray-500 text-sm">শিক্ষক</p>
        <p class="text-2xl font-bold">{{ $stats['teachers'] }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-gray-500 text-sm">শিক্ষার্থী</p>
        <p class="text-2xl font-bold">{{ $stats['students'] }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-gray-500 text-sm">স্টাফ</p>
        <p class="text-2xl font-bold">{{ $stats['staff'] }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <p class="text-gray-500 text-sm">বকেয়া ফি</p>
        <p class="text-2xl font-bold">{{ number_format($stats['due_fees'], 2) }}</p>
    </div>
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
@endsection
