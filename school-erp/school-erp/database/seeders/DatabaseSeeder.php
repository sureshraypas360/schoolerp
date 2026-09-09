<?php

namespace Database\Seeders;

use App\Models\FeeType;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@school.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Demo school structure
        $school = School::create([
            'name' => 'Green View High School',
            'email' => 'info@greenview.test',
            'phone' => '01700000000',
            'address' => 'Dhaka, Bangladesh',
        ]);

        $class = SchoolClass::create(['school_id' => $school->id, 'name' => 'Class 6']);
        $section = Section::create(['class_id' => $class->id, 'name' => 'A']);

        $mathSubject = Subject::create(['school_id' => $school->id, 'class_id' => $class->id, 'name' => 'Mathematics', 'code' => 'MATH-06']);
        Subject::create(['school_id' => $school->id, 'class_id' => $class->id, 'name' => 'English', 'code' => 'ENG-06']);

        // Teacher
        $teacherUser = User::create([
            'name' => 'Karim Rahman',
            'email' => 'teacher@school.test',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'school_id' => $school->id,
            'employee_id' => 'EMP-001',
            'qualification' => 'M.Sc',
            'joining_date' => now()->subYears(2),
        ]);
        $teacher->subjects()->attach($mathSubject->id, ['section_id' => $section->id]);

        // Student
        $studentUser = User::create([
            'name' => 'Rafi Islam',
            'email' => 'student@school.test',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        Student::create([
            'user_id' => $studentUser->id,
            'school_id' => $school->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
            'admission_no' => 'ADM-0001',
            'roll_no' => '1',
            'guardian_name' => 'Abdul Islam',
            'guardian_phone' => '01800000000',
            'admission_date' => now()->subMonths(6),
        ]);

        // Staff (accountant)
        $staffUser = User::create([
            'name' => 'Nasrin Akter',
            'email' => 'staff@school.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
        Staff::create([
            'user_id' => $staffUser->id,
            'school_id' => $school->id,
            'employee_id' => 'STF-001',
            'designation' => 'Accountant',
            'joining_date' => now()->subYear(),
        ]);

        // Fee type
        FeeType::create(['school_id' => $school->id, 'name' => 'Tuition Fee (Monthly)', 'amount' => 1500]);

        $this->command->info('Seeded. Login: admin@school.test / teacher@school.test / student@school.test / staff@school.test — password: password');
    }
}
