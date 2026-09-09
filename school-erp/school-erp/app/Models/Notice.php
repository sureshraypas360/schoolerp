<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['school_id', 'title', 'description', 'published_by', 'publish_date'];

    protected function casts(): array
    {
        return ['publish_date' => 'date'];
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
}
