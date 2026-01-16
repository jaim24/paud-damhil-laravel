<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nisn',
        'name',
        'gender',
        'class_group',
        'academic_year',
        'status',
        'parent_name',
        'parent_phone',
        'notes',
        'show_public'
    ];

    protected $casts = [
        'show_public' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
