@extends('layouts.admin')
@section('page-title', 'বিষয় সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.subjects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন বিষয়</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">বিষয়</th><th class="p-3">কোড</th><th class="p-3">ক্লাস</th><th class="p-3">স্কুল</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($subjects as $subject)
            <tr class="border-t">
                <td class="p-3">{{ $subject->name }}</td>
                <td class="p-3">{{ $subject->code }}</td>
                <td class="p-3">{{ $subject->schoolClass->name }}</td>
                <td class="p-3">{{ $subject->schoolClass->school->name }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $subjects->links() }}</div>
@endsection
