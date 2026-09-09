@extends('layouts.student')
@section('page-title', 'আমার উপস্থিতি')
@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr><th class="p-3">তারিখ</th><th class="p-3">স্ট্যাটাস</th></tr></thead>
        <tbody>
        @forelse ($attendances as $attendance)
            <tr class="border-t">
                <td class="p-3">{{ $attendance->date->format('d M, Y') }}</td>
                <td class="p-3 capitalize">{{ $attendance->status }}</td>
            </tr>
        @empty
            <tr><td colspan="2" class="p-3 text-gray-500">কোনো তথ্য নেই।</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $attendances?->links() }}</div>
@endsection
