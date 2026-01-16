<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'summary',
        'content',
        'published_date',
        'category',
        'status',
        'show_on_home'
    ];

    protected $casts = [
        'published_date' => 'date',
        'show_on_home' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOnHome($query)
    {
        return $query->where('show_on_home', true);
    }

    public function scopeBerita($query)
    {
        return $query->where('category', 'berita');
    }

    public function scopePengumuman($query)
    {
        return $query->where('category', 'pengumuman');
    }
}
