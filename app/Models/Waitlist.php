<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $fillable = [
        'child_name',
        'birth_place',
        'birth_date',
        'gender',
        'father_name',
        'father_job',
        'mother_name',
        'mother_job',
        'address',
        'phone',
        'notes',
        'status',
        'observation_date',
        'observation_notes',
        'transferred_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'observation_date' => 'datetime',
        'transferred_at' => 'datetime',
    ];

    // Status constants
    const STATUS_WAITING = 'waiting';           // Baru daftar
    const STATUS_SCHEDULED = 'scheduled';       // Sudah dijadwalkan observasi
    const STATUS_PASSED = 'passed';             // Lulus observasi
    const STATUS_FAILED = 'failed';             // Tidak lulus observasi
    const STATUS_TRANSFERRED = 'transferred';   // Sudah lanjut ke form administrasi

    // Scopes
    public function scopeWaiting($query)
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    public function scopePassed($query)
    {
        return $query->where('status', self::STATUS_PASSED);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeTransferred($query)
    {
        return $query->where('status', self::STATUS_TRANSFERRED);
    }

    // Get gender label
    public function getGenderLabelAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_WAITING => 'Menunggu',
            self::STATUS_SCHEDULED => 'Terjadwal Observasi',
            self::STATUS_PASSED => 'Lulus Observasi',
            self::STATUS_FAILED => 'Tidak Lulus',
            self::STATUS_TRANSFERRED => 'Lanjut Administrasi',
            default => 'Unknown',
        };
    }

    // Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_WAITING => 'amber',
            self::STATUS_SCHEDULED => 'blue',
            self::STATUS_PASSED => 'green',
            self::STATUS_FAILED => 'red',
            self::STATUS_TRANSFERRED => 'purple',
            default => 'slate',
        };
    }

    // Schedule observation
    public function scheduleObservation($date, $notes = null)
    {
        $this->update([
            'status' => self::STATUS_SCHEDULED,
            'observation_date' => $date,
            'observation_notes' => $notes,
        ]);
    }

    // Mark as passed observation
    public function markPassed($notes = null)
    {
        $this->update([
            'status' => self::STATUS_PASSED,
            'observation_notes' => $notes ?? $this->observation_notes,
        ]);
    }

    // Mark as failed observation
    public function markFailed($notes = null)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'observation_notes' => $notes ?? $this->observation_notes,
        ]);
    }

    // Transfer to Applicant - untuk mengisi form administrasi
    public function transferToApplicant()
    {
        // Cek apakah sudah lulus observasi
        if ($this->status !== self::STATUS_PASSED) {
            throw new \Exception('Hanya yang lulus observasi yang bisa lanjut administrasi');
        }

        $applicant = \App\Models\Applicant::create([
            // Data Murid
            'child_name' => $this->child_name,
            'birth_place' => $this->birth_place ?? 'Gorontalo',
            'birth_date' => $this->birth_date,
            'gender' => $this->gender ?? 'L',
            'religion' => 'Islam',
            'citizenship' => 'WNI',
            'address_street' => $this->address ?? '-',
            'living_with' => 'orang_tua',
            
            // Data Orang Tua
            'father_name' => $this->father_name ?? '-',
            'mother_name' => $this->mother_name ?? '-',
            'father_job' => $this->father_job,
            'mother_job' => $this->mother_job,
            
            // Kontak
            'phone' => $this->phone,
            
            // Status - langsung ke administrasi
            'status' => 'administrasi',
            'waitlist_id' => $this->id,
            'notes' => 'Lulus Observasi: ' . ($this->observation_notes ?? '-'),
        ]);

        $this->update([
            'status' => self::STATUS_TRANSFERRED,
            'transferred_at' => now(),
        ]);

        return $applicant;
    }

    // Relationship to applicant
    public function applicant()
    {
        return $this->hasOne(Applicant::class);
    }
}
