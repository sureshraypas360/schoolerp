<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeInvoice extends Model
{
    protected $fillable = [
        'student_id', 'fee_type_id', 'amount', 'paid_amount', 'due_date', 'status', 'paid_at', 'collected_by',
    ];

    protected function casts(): array
    {
        return ['due_date' => 'date', 'paid_at' => 'datetime'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function dueAmount(): float
    {
        return (float) $this->amount - (float) $this->paid_amount;
    }
}
