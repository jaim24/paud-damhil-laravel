<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        // Data Murid
        'child_name',
        'nickname',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'citizenship',
        'siblings_kandung',
        'siblings_tiri',
        'siblings_angkat',
        'child_order',
        'daily_language',
        'weight',
        'height',
        'head_circumference',
        'blood_type',
        'address_street',
        'address_kelurahan',
        'address_kecamatan',
        'living_with',
        'distance_km',
        'distance_minutes',
        'transportation',
        'hobby',
        'aspiration',
        // Data Orang Tua
        'father_name',
        'mother_name',
        'father_birth_year',
        'mother_birth_year',
        'father_education',
        'mother_education',
        'father_job',
        'mother_job',
        'father_income',
        'mother_income',
        // Wali
        'guardian_name',
        'guardian_relationship',
        'guardian_education',
        'guardian_job',
        // Kontak
        'phone',
        'email',
        // Status
        'status',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'siblings_kandung' => 'integer',
        'siblings_tiri' => 'integer',
        'siblings_angkat' => 'integer',
        'child_order' => 'integer',
    ];

    // Accessors
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address_street,
            $this->address_kelurahan ? 'Kel. ' . $this->address_kelurahan : null,
            $this->address_kecamatan ? 'Kec. ' . $this->address_kecamatan : null,
        ]);
        return implode(', ', $parts);
    }

    public function getGenderLabelAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getLivingWithLabelAttribute()
    {
        return match($this->living_with) {
            'orang_tua' => 'Orang Tua',
            'menumpang' => 'Menumpang',
            'asrama' => 'Asrama',
            default => '-',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Pending' => '<span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">Menunggu</span>',
            'Accepted' => '<span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Diterima</span>',
            'Rejected' => '<span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Ditolak</span>',
            default => '-',
        };
    }

    // Query Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'Accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }
}
