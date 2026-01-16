<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'child_name',
        'birth_date',
        'parent_name',
        'phone',
        'address',
        'status',
        'notes'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'Accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }
}
