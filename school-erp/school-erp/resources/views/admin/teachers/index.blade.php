@extends('layouts.admin')
@section('page-title', 'শিক্ষক সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.teachers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন শিক্ষক</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">নাম</th><th class="p-3">ইমেইল</th><th class="p-3">এমপ্লয়ি আইডি</th><th class="p-3">স্কুল</th><th class="p-3">স্ট্যাটাস</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($teachers as $teacher)
            <tr class="border-t">
                <td class="p-3">{{ $teacher->user->name }}</td>
                <td class="p-3">{{ $teacher->user->email }}</td>
                <td class="p-3">{{ $teacher->employee_id }}</td>
                <td class="p-3">{{ $teacher->school->name }}</td>
                <td class="p-3">{{ $teacher->user->status }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $teachers->links() }}</div>
@endsection
