<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['school_id', 'class_id', 'name', 'start_date', 'end_date'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }
}
