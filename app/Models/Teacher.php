<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'position',
        'education',
        'status',
        'photo',
        'experience_years',
        'motto',
        'show_public'
    ];

    protected $casts = [
        'show_public' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('show_public', true);
    }
}
