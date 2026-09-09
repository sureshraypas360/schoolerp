@extends('layouts.admin')

@section('page-title', 'স্কুল সমূহ')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.schools.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন স্কুল</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="p-3">নাম</th>
                <th class="p-3">ইমেইল</th>
                <th class="p-3">ফোন</th>
                <th class="p-3">ক্লাস</th>
                <th class="p-3">শিক্ষক</th>
                <th class="p-3">শিক্ষার্থী</th>
                <th class="p-3">স্ট্যাটাস</th>
                <th class="p-3">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($schools as $school)
            <tr class="border-t">
                <td class="p-3">{{ $school->name }}</td>
                <td class="p-3">{{ $school->email }}</td>
                <td class="p-3">{{ $school->phone }}</td>
                <td class="p-3">{{ $school->classes_count }}</td>
                <td class="p-3">{{ $school->teachers_count }}</td>
                <td class="p-3">{{ $school->students_count }}</td>
                <td class="p-3">{{ $school->status }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.schools.edit', $school) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $schools->links() }}</div>
@endsection
