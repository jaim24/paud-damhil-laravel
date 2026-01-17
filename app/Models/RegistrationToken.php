<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegistrationToken extends Model
{
    protected $fillable = [
        'token',
        'waitlist_id',
        'child_name',
        'phone',
        'is_used',
        'used_at',
        'expires_at',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function waitlist()
    {
        return $this->belongsTo(Waitlist::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Generate unique token
    public static function generateToken()
    {
        do {
            $token = strtoupper(Str::random(8));
        } while (self::where('token', $token)->exists());
        
        return $token;
    }

    // Validate token
    public static function validateToken($token)
    {
        $record = self::where('token', strtoupper($token))->first();
        
        if (!$record) {
            return ['valid' => false, 'message' => 'Kode akses tidak ditemukan.'];
        }
        
        if ($record->is_used) {
            return ['valid' => false, 'message' => 'Kode akses sudah digunakan.'];
        }
        
        if ($record->expires_at && $record->expires_at->isPast()) {
            return ['valid' => false, 'message' => 'Kode akses sudah kadaluarsa.'];
        }
        
        return ['valid' => true, 'token' => $record];
    }

    // Mark as used
    public function markAsUsed()
    {
        $this->update([
            'is_used' => true,
            'used_at' => now(),
        ]);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_used', false)
                     ->where(function ($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }
}
