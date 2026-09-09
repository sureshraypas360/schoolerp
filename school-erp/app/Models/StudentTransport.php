<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTransport extends Model
{
    protected $table = 'student_transport';

    protected $fillable = ['transport_route_id', 'student_id', 'assigned_date'];

    protected function casts(): array
    {
        return ['assigned_date' => 'date'];
    }

    public function route()
    {
        return $this->belongsTo(TransportRoute::class, 'transport_route_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
