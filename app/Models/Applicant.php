<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    // Status constants - alur baru SPMB
    const STATUS_ADMINISTRASI = 'administrasi';     // Isi form lengkap
    const STATUS_DECLARATION = 'declaration';        // Menunggu upload surat pernyataan
    const STATUS_PAYMENT = 'payment';               // Menunggu pembayaran
    const STATUS_PAID = 'paid';                     // Sudah bayar
    const STATUS_ACCEPTED = 'accepted';             // Diterima sebagai siswa
    const STATUS_REJECTED = 'rejected';             // Ditolak

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
        // Surat Pernyataan
        'declaration_file',
        'declaration_uploaded_at',
        // Pembayaran
        'registration_fee',
        'payment_status',
        'payment_date',
        'payment_proof',
        // Tahun Ajaran & Referensi
        'academic_year',
        'waitlist_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'declaration_uploaded_at' => 'datetime',
        'payment_date' => 'datetime',
        'siblings_kandung' => 'integer',
        'siblings_tiri' => 'integer',
        'siblings_angkat' => 'integer',
        'child_order' => 'integer',
        'registration_fee' => 'decimal:2',
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

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_ADMINISTRASI => 'Mengisi Formulir',
            self::STATUS_DECLARATION => 'Upload Surat Pernyataan',
            self::STATUS_PAYMENT => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Sudah Bayar',
            self::STATUS_ACCEPTED => 'Diterima',
            self::STATUS_REJECTED => 'Ditolak',
            // Legacy support
            'Pending' => 'Menunggu',
            'Accepted' => 'Diterima',
            'Rejected' => 'Ditolak',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_ADMINISTRASI => 'amber',
            self::STATUS_DECLARATION => 'blue',
            self::STATUS_PAYMENT => 'purple',
            self::STATUS_PAID => 'green',
            self::STATUS_ACCEPTED => 'emerald',
            self::STATUS_REJECTED => 'red',
            'Pending' => 'amber',
            'Accepted' => 'green',
            'Rejected' => 'red',
            default => 'slate',
        };
    }

    public function getStatusBadgeAttribute()
    {
        $color = $this->status_color;
        $label = $this->status_label;
        return "<span class=\"px-2 py-1 bg-{$color}-100 text-{$color}-700 rounded-full text-xs font-medium\">{$label}</span>";
    }

    // Query Scopes
    public function scopeAdministrasi($query)
    {
        return $query->where('status', self::STATUS_ADMINISTRASI);
    }

    public function scopeDeclaration($query)
    {
        return $query->where('status', self::STATUS_DECLARATION);
    }

    public function scopePayment($query)
    {
        return $query->where('status', self::STATUS_PAYMENT);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', self::STATUS_ACCEPTED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    // Legacy scopes for backward compatibility
    public function scopePending($query)
    {
        return $query->whereIn('status', ['Pending', self::STATUS_ADMINISTRASI, self::STATUS_DECLARATION, self::STATUS_PAYMENT]);
    }

    // Relationships
    public function waitlist()
    {
        return $this->belongsTo(Waitlist::class);
    }

    // Actions
    public function uploadDeclaration($filePath)
    {
        $this->update([
            'declaration_file' => $filePath,
            'declaration_uploaded_at' => now(),
            'status' => self::STATUS_PAYMENT,
        ]);
    }

    public function markAsPaid($proof = null, $amount = null)
    {
        $this->update([
            'payment_status' => 'paid',
            'payment_date' => now(),
            'payment_proof' => $proof,
            'registration_fee' => $amount ?? $this->registration_fee,
            'status' => self::STATUS_PAID,
        ]);
    }

    public function acceptAsStudent()
    {
        $this->update([
            'status' => self::STATUS_ACCEPTED,
        ]);
    }

    public function reject($reason = null)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'notes' => $reason ?? $this->notes,
        ]);
    }
}
