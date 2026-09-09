@extends('layouts.app')

@section('nav')
    <a href="{{ route('student.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ড্যাশবোর্ড</a>
    <a href="{{ route('student.attendance') }}" class="block px-3 py-2 rounded hover:bg-gray-800">উপস্থিতি</a>
    <a href="{{ route('student.fees') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ফি</a>
    <a href="{{ route('student.results') }}" class="block px-3 py-2 rounded hover:bg-gray-800">রেজাল্ট</a>
    <a href="{{ route('student.homework') }}" class="block px-3 py-2 rounded hover:bg-gray-800">হোমওয়ার্ক</a>
    <a href="{{ route('student.facilities') }}" class="block px-3 py-2 rounded hover:bg-gray-800">সুবিধাসমূহ</a>
@endsection
