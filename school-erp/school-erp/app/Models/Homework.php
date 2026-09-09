<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['subject_id', 'section_id', 'teacher_id', 'title', 'description', 'given_date', 'due_date'];

    protected function casts(): array
    {
        return ['given_date' => 'date', 'due_date' => 'date'];
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
