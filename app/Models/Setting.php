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
        'mission',
        // SPMB Settings
        'spmb_status',
        'spmb_quota',
        'spmb_start_date',
        'spmb_end_date',
        'spmb_closed_message',
    ];

    protected $casts = [
        'spmb_start_date' => 'date',
        'spmb_end_date' => 'date',
        'spmb_quota' => 'integer',
    ];

    // Helper to get the first settings record
    public static function getSettings()
    {
        return self::first() ?? new self();
    }

    // Check if SPMB is open
    public function isSpmbOpen()
    {
        if ($this->spmb_status !== 'open') {
            return false;
        }

        $today = now()->startOfDay();
        
        // Check date range if set
        if ($this->spmb_start_date && $today->lt($this->spmb_start_date)) {
            return false;
        }
        
        if ($this->spmb_end_date && $today->gt($this->spmb_end_date)) {
            return false;
        }

        // Check quota
        $currentApplicants = \App\Models\Applicant::count();
        if ($currentApplicants >= $this->spmb_quota) {
            return false;
        }

        return true;
    }

    // Check if waitlist is open
    public function isWaitlistOpen()
    {
        return in_array($this->spmb_status, ['waitlist_only', 'closed']);
    }

    // Get remaining quota
    public function getRemainingQuota()
    {
        $currentApplicants = \App\Models\Applicant::count();
        return max(0, $this->spmb_quota - $currentApplicants);
    }

    // Get SPMB status label
    public function getSpmbStatusLabel()
    {
        return match($this->spmb_status) {
            'open' => 'Dibuka',
            'closed' => 'Ditutup',
            'waitlist_only' => 'Hanya Daftar Tunggu',
            default => 'Tidak Diketahui',
        };
    }
}
