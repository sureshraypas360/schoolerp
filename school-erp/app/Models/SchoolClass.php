<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'school_classes';

    protected $fillable = ['school_id', 'name'];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }
}
