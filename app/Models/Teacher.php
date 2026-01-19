<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Teacher extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'nip',
        'name',
        'email',
        'phone',
        'password',
        'position',
        'education',
        'status',
        'photo',
        'experience_years',
        'motto',
        'show_public',
        'api_token',
        'device_token',
        'last_login_at',
        'password_reset_requested_at',
    ];

    protected $hidden = [
        'password',
        'api_token',
    ];

    protected $casts = [
        'show_public' => 'boolean',
        'last_login_at' => 'datetime',
        'password_reset_requested_at' => 'datetime',
    ];

    // Relationships
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('show_public', true);
    }

    // Generate API token for Flutter app
    public function generateApiToken()
    {
        $this->api_token = Str::random(60);
        $this->last_login_at = now();
        $this->save();
        return $this->api_token;
    }

    // Get today's attendance
    public function getTodayAttendanceAttribute()
    {
        return $this->attendances()->whereDate('date', Carbon::today())->first();
    }

    // Check if already checked in today
    public function hasCheckedInToday()
    {
        return $this->attendances()
            ->whereDate('date', Carbon::today())
            ->whereNotNull('check_in')
            ->exists();
    }

    // Check if already checked out today
    public function hasCheckedOutToday()
    {
        return $this->attendances()
            ->whereDate('date', Carbon::today())
            ->whereNotNull('check_out')
            ->exists();
    }

    // Get attendance stats for current month
    public function getMonthlyStatsAttribute()
    {
        $attendances = $this->attendances()->thisMonth()->get();
        
        return [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'terlambat' => $attendances->where('status', 'terlambat')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'alpha' => $attendances->where('status', 'alpha')->count(),
            'total' => $attendances->count(),
        ];
    }
}

