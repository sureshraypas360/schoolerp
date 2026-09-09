@extends('layouts.app')

@section('nav')
    <a href="{{ route('staff.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ড্যাশবোর্ড</a>
    <a href="{{ route('staff.fees.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">ফি সংগ্রহ</a>
@endsection
