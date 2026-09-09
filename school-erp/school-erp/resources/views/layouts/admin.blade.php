@extends('layouts.app')

@section('nav')
    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ড্যাশবোর্ড</a>
    <a href="{{ route('admin.schools.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">স্কুল</a>
    <a href="{{ route('admin.classes.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ক্লাস</a>
    <a href="{{ route('admin.sections.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">সেকশন</a>
    <a href="{{ route('admin.subjects.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">বিষয়</a>
    <a href="{{ route('admin.teachers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">শিক্ষক</a>
    <a href="{{ route('admin.students.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">শিক্ষার্থী</a>
    <a href="{{ route('admin.staff.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">স্টাফ</a>
    <a href="{{ route('admin.attendance.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">উপস্থিতি রিপোর্ট</a>
    <a href="{{ route('admin.fees.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ফি</a>
    <a href="{{ route('admin.exams.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">পরীক্ষা</a>
    <a href="{{ route('admin.notices.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">নোটিশ</a>
    <a href="{{ route('admin.library.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">লাইব্রেরি</a>
    <a href="{{ route('admin.hostel.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">হোস্টেল</a>
    <a href="{{ route('admin.transport.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ট্রান্সপোর্ট</a>
    <a href="{{ route('admin.idcards.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">আইডি কার্ড</a>
@endsection
