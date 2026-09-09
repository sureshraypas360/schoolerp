<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $fillable = ['school_id', 'name', 'amount'];

    public function invoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }
}
