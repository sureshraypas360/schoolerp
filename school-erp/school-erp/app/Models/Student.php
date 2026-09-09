<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'school_id', 'class_id', 'section_id', 'admission_no',
        'roll_no', 'guardian_name', 'guardian_phone', 'dob', 'gender', 'admission_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function invoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }

    public function hostelAllocations()
    {
        return $this->hasMany(HostelAllocation::class);
    }

    public function transportAssignments()
    {
        return $this->hasMany(StudentTransport::class, 'student_id');
    }
}
