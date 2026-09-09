@extends('layouts.admin')
@section('page-title', 'সেকশন সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.sections.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন সেকশন</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">সেকশন</th><th class="p-3">ক্লাস</th><th class="p-3">স্কুল</th><th class="p-3">শিক্ষার্থী</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($sections as $section)
            <tr class="border-t">
                <td class="p-3">{{ $section->name }}</td>
                <td class="p-3">{{ $section->schoolClass->name }}</td>
                <td class="p-3">{{ $section->schoolClass->school->name }}</td>
                <td class="p-3">{{ $section->students_count }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.sections.edit', $section) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $sections->links() }}</div>
@endsection
