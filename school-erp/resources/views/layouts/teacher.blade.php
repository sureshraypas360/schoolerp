@extends('layouts.app')

@section('nav')
    <a href="{{ route('teacher.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ড্যাশবোর্ড</a>
    <a href="{{ route('teacher.attendance.create') }}" class="block px-3 py-2 rounded hover:bg-gray-800">উপস্থিতি নিন</a>
    <a href="{{ route('teacher.exams.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">পরীক্ষার মার্কস</a>
    <a href="{{ route('teacher.homework.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">হোমওয়ার্ক</a>
@endsection
