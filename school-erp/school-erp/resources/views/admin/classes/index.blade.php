@extends('layouts.admin')
@section('page-title', 'ক্লাস সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.classes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন ক্লাস</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">ক্লাস</th><th class="p-3">স্কুল</th><th class="p-3">সেকশন সংখ্যা</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($classes as $class)
            <tr class="border-t">
                <td class="p-3">{{ $class->name }}</td>
                <td class="p-3">{{ $class->school->name }}</td>
                <td class="p-3">{{ $class->sections_count }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.classes.edit', $class) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $classes->links() }}</div>
@endsection
