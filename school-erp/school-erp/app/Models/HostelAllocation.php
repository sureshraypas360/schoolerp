<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelAllocation extends Model
{
    protected $fillable = ['hostel_room_id', 'student_id', 'allocated_date', 'vacated_date'];

    protected function casts(): array
    {
        return ['allocated_date' => 'date', 'vacated_date' => 'date'];
    }

    public function room()
    {
        return $this->belongsTo(HostelRoom::class, 'hostel_room_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
