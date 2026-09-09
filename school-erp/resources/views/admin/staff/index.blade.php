@extends('layouts.admin')
@section('page-title', 'স্টাফ সমূহ')
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.staff.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">+ নতুন স্টাফ</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left"><tr>
            <th class="p-3">নাম</th><th class="p-3">ইমেইল</th><th class="p-3">পদবি</th><th class="p-3">স্কুল</th><th class="p-3">অ্যাকশন</th>
        </tr></thead>
        <tbody>
        @foreach ($staff as $member)
            <tr class="border-t">
                <td class="p-3">{{ $member->user->name }}</td>
                <td class="p-3">{{ $member->user->email }}</td>
                <td class="p-3">{{ $member->designation }}</td>
                <td class="p-3">{{ $member->school->name }}</td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('admin.staff.edit', $member) }}" class="text-indigo-600">এডিট</a>
                    <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('নিশ্চিত?')">
                        @csrf @method('DELETE')<button class="text-red-600">মুছুন</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $staff->links() }}</div>
@endsection
