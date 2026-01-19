<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'date',
        'check_in',
        'check_out',
        'check_in_photo',
        'check_out_photo',
        'check_in_latitude',
        'check_in_longitude',
        'check_out_latitude',
        'check_out_longitude',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_latitude' => 'decimal:8',
        'check_in_longitude' => 'decimal:8',
        'check_out_latitude' => 'decimal:8',
        'check_out_longitude' => 'decimal:8',
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('date', Carbon::today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', Carbon::now()->month)
                     ->whereYear('date', Carbon::now()->year);
    }

    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeHadir($query)
    {
        return $query->whereIn('status', ['hadir', 'terlambat']);
    }

    // Helpers
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'hadir' => 'green',
            'terlambat' => 'amber',
            'izin' => 'blue',
            'sakit' => 'purple',
            'alpha' => 'red',
            default => 'slate',
        };
    }

    public function getWorkDurationAttribute()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            $diff = $checkIn->diff($checkOut);
            return $diff->format('%H jam %I menit');
        }
        return '-';
    }

    // Check if late (after 07:30)
    public function isLate($threshold = '07:30:00')
    {
        if ($this->check_in) {
            return Carbon::parse($this->check_in)->format('H:i:s') > $threshold;
        }
        return false;
    }
}
