<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelRoom extends Model
{
    protected $fillable = ['school_id', 'room_no', 'capacity'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function allocations()
    {
        return $this->hasMany(HostelAllocation::class);
    }

    public function activeAllocations()
    {
        return $this->hasMany(HostelAllocation::class)->whereNull('vacated_date');
    }
}
