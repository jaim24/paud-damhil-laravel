<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Refactoring SPMB - Update Applicants Table
     * Menambah field untuk surat pernyataan dan pembayaran
     */
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Surat Pernyataan - upload file yang sudah ditandatangani
            $table->string('declaration_file')->nullable()->after('status');
            $table->datetime('declaration_uploaded_at')->nullable()->after('declaration_file');
            
            // Pembayaran
            $table->decimal('registration_fee', 12, 2)->nullable()->after('declaration_uploaded_at');
            $table->string('payment_status')->default('pending')->after('registration_fee'); // pending, paid
            $table->datetime('payment_date')->nullable()->after('payment_status');
            $table->string('payment_proof')->nullable()->after('payment_date'); // bukti bayar
            
            // Tahun ajaran
            $table->string('academic_year')->nullable()->after('payment_proof');
            
            // Source - dari waitlist mana
            $table->foreignId('waitlist_id')->nullable()->after('academic_year');
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'declaration_file',
                'declaration_uploaded_at',
                'registration_fee',
                'payment_status',
                'payment_date',
                'payment_proof',
                'academic_year',
                'waitlist_id'
            ]);
        });
    }
};
