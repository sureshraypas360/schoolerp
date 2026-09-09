@extends('layouts.teacher')
@section('page-title', 'পরীক্ষার মার্কস')
@section('content')
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">পরীক্ষা</th><th class="p-3">ক্লাস</th><th class="p-3">বিষয় সমূহ</th>
        </tr></thead>
        <tbody>
        @foreach ($exams as $exam)
            <tr class="border-t align-top">
                <td class="p-3">{{ $exam->name }}</td>
                <td class="p-3">{{ $exam->schoolClass->name }}</td>
                <td class="p-3 space-x-2">
                    @foreach ($exam->examSubjects as $es)
                        <a href="{{ route('teacher.exams.marks', $es) }}" class="text-indigo-600 inline-block">{{ $es->subject->name }}</a>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
