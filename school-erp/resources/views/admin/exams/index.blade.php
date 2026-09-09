@extends('layouts.admin')
@section('page-title', 'পরীক্ষা সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.exams.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন পরীক্ষা</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">পরীক্ষার নাম</th><th class="p-3">ক্লাস</th><th class="p-3">বিষয় সংখ্যা</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($exams as $exam)
            <tr class="border-t">
                <td class="p-3">{{ $exam->name }}</td>
                <td class="p-3">{{ $exam->schoolClass->name }}</td>
                <td class="p-3">{{ $exam->exam_subjects_count }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.exams.show', $exam) }}" class="text-indigo-600">বিস্তারিত</a>
                    <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $exams->links() }}</div>
@endsection
