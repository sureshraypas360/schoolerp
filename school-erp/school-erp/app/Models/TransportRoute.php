<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    protected $fillable = ['school_id', 'route_name', 'vehicle_no', 'driver_name', 'driver_phone', 'fare'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function assignments()
    {
        return $this->hasMany(StudentTransport::class);
    }
}
