<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with(['user', 'school'])->latest()->paginate(15);

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();

        return view('admin.staff.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'school_id' => ['required', 'exists:schools,id'],
            'employee_id' => ['required', 'string', 'unique:staff,employee_id'],
            'designation' => ['nullable', 'string', 'max:255'],
            'joining_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'staff',
                'phone' => $data['phone'] ?? null,
            ]);

            Staff::create([
                'user_id' => $user->id,
                'school_id' => $data['school_id'],
                'employee_id' => $data['employee_id'],
                'designation' => $data['designation'] ?? null,
                'joining_date' => $data['joining_date'] ?? null,
                'salary' => $data['salary'] ?? null,
            ]);
        });

        return redirect()->route('admin.staff.index')->with('status', 'স্টাফ যোগ করা হয়েছে।');
    }

    public function edit(Staff $member)
    {
        $member->load('user');
        $schools = School::orderBy('name')->get();

        return view('admin.staff.edit', ['staff' => $member, 'schools' => $schools]);
    }

    public function update(Request $request, Staff $member)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$member->user_id],
            'school_id' => ['required', 'exists:schools,id'],
            'employee_id' => ['required', 'string', 'unique:staff,employee_id,'.$member->id],
            'designation' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        DB::transaction(function () use ($data, $member) {
            $member->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $data['status'],
            ]);

            $member->update([
                'school_id' => $data['school_id'],
                'employee_id' => $data['employee_id'],
                'designation' => $data['designation'] ?? null,
            ]);
        });

        return redirect()->route('admin.staff.index')->with('status', 'স্টাফের তথ্য আপডেট হয়েছে।');
    }

    public function destroy(Staff $member)
    {
        $member->user()->delete();
        $member->delete();

        return back()->with('status', 'স্টাফ মুছে ফেলা হয়েছে।');
    }
}
