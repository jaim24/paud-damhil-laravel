<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'event_date',
        'is_active',
        'show_on_home'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
        'show_on_home' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOnHome($query)
    {
        return $query->where('show_on_home', true);
    }
}
