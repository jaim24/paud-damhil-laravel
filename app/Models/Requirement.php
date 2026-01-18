<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'type',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDocuments($query)
    {
        return $query->where('type', 'document');
    }

    public function scopeUniforms($query)
    {
        return $query->where('type', 'uniform');
    }

    public function scopeFees($query)
    {
        return $query->where('type', 'fee');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    // Get type label
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'document' => 'Dokumen',
            'uniform' => 'Seragam',
            'fee' => 'Biaya',
            'other' => 'Lainnya',
            default => 'Lainnya',
        };
    }
}
