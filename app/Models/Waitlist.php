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
        'transferred_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'transferred_at' => 'datetime',
    ];

    // Scopes
    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeTransferred($query)
    {
        return $query->where('status', 'transferred');
    }

    // Get gender label
    public function getGenderLabelAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Transfer to Applicant - Updated for new schema
    public function transferToApplicant()
    {
        $applicant = \App\Models\Applicant::create([
            // Data Murid
            'child_name' => $this->child_name,
            'birth_place' => $this->birth_place ?? 'Gorontalo', // Default if empty
            'birth_date' => $this->birth_date,
            'gender' => $this->gender ?? 'L',
            'religion' => 'Islam', // Default
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
            
            // Status
            'status' => 'Pending',
            'notes' => 'Transfer dari Daftar Tunggu',
        ]);

        $this->update([
            'status' => 'transferred',
            'transferred_at' => now(),
        ]);

        return $applicant;
    }
}
