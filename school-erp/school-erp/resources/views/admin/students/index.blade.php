@extends('layouts.admin')
@section('page-title', 'শিক্ষার্থী সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.students.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন ভর্তি</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">নাম</th><th class="p-3">ভর্তি নং</th><th class="p-3">ক্লাস</th><th class="p-3">সেকশন</th><th class="p-3">স্কুল</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($students as $student)
            <tr class="border-t">
                <td class="p-3">{{ $student->user->name }}</td>
                <td class="p-3">{{ $student->admission_no }}</td>
                <td class="p-3">{{ $student->schoolClass->name }}</td>
                <td class="p-3">{{ $student->section->name }}</td>
                <td class="p-3">{{ $student->school->name }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.students.edit', $student) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $students->links() }}</div>
@endsection
