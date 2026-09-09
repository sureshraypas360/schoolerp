@extends('layouts.student')
@section('page-title', 'হোমওয়ার্ক')
@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">বিষয়</th><th class="p-3">শিরোনাম</th><th class="p-3">বিবরণ</th><th class="p-3">শিক্ষক</th><th class="p-3">শেষ তারিখ</th>
        </tr></thead>
        <tbody>
        @forelse ($homeworks as $homework)
            <tr class="border-t">
                <td class="p-3">{{ $homework->subject->name }}</td>
                <td class="p-3">{{ $homework->title }}</td>
                <td class="p-3">{{ $homework->description }}</td>
                <td class="p-3">{{ $homework->teacher->user->name }}</td>
                <td class="p-3">{{ $homework->due_date?->format('d M, Y') }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="p-3 text-gray-500">কোনো হোমওয়ার্ক নেই।</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $homeworks->links() }}</div>
@endsection
