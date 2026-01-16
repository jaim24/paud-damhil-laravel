<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'school_name',
        'logo',
        'welcome_text',
        'sub_text',
        'contact_phone',
        'email',
        'contact_address',
        'about',
        'vision',
        'mission'
    ];

    // Helper to get the first settings record
    public static function getSettings()
    {
        return self::first() ?? new self();
    }
}
