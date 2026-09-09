@extends('layouts.student')
@section('page-title', 'আমার রেজাল্ট')
@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">পরীক্ষা</th><th class="p-3">বিষয়</th><th class="p-3">প্রাপ্ত নম্বর</th><th class="p-3">পূর্ণমান</th><th class="p-3">ফলাফল</th>
        </tr></thead>
        <tbody>
        @forelse ($results as $result)
            <tr class="border-t">
                <td class="p-3">{{ $result->examSubject->exam->name }}</td>
                <td class="p-3">{{ $result->examSubject->subject->name }}</td>
                <td class="p-3">{{ $result->marks_obtained }}</td>
                <td class="p-3">{{ $result->examSubject->full_marks }}</td>
                <td class="p-3">{{ $result->grade }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="p-3 text-gray-500">কোনো রেজাল্ট নেই।</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $results?->links() }}</div>
@endsection
