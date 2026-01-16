<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppInvoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nisn',
        'student_name',
        'month',
        'amount',
        'status',
        'due_date',
        'paid_date',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'Unpaid');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'Paid');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }
}
