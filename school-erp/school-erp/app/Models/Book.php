<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['school_id', 'title', 'author', 'isbn', 'total_copies', 'available_copies'];

    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}
