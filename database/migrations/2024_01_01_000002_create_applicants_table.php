<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            
            // A. KETERANGAN MURID
            // 1. Nama
            $table->string('child_name'); // Nama Lengkap
            $table->string('nickname')->nullable(); // Nama Panggilan
            
            // 2. Jenis Kelamin
            $table->enum('gender', ['L', 'P'])->default('L');
            
            // 3. Kelahiran
            $table->string('birth_place')->default('-'); // Nullable with default
            $table->date('birth_date');
            
            // 4. Agama
            $table->string('religion')->nullable();
            
            // 5. Kewarganegaraan
            $table->enum('citizenship', ['WNI', 'WNA'])->default('WNI');
            
            // 6. Jumlah Saudara
            $table->integer('siblings_kandung')->default(0);
            $table->integer('siblings_tiri')->default(0);
            $table->integer('siblings_angkat')->default(0);
            $table->integer('child_order')->default(1); // Anak ke
            
            // 7. Bahasa sehari-hari
            $table->string('daily_language')->nullable();
            
            // 8. Keadaan Jasmani
            $table->string('weight')->nullable(); // Berat Badan
            $table->string('height')->nullable(); // Tinggi Badan
            $table->string('head_circumference')->nullable(); // Lingkar Kepala
            $table->enum('blood_type', ['A', 'B', 'AB', 'O', '-'])->nullable();
            
            // 9. Alamat
            $table->text('address_street')->nullable(); // Jalan
            $table->string('address_kelurahan')->nullable();
            $table->string('address_kecamatan')->nullable();
            
            // 10. Bertempat Tinggal Pada
            $table->enum('living_with', ['orang_tua', 'menumpang', 'asrama'])->default('orang_tua');
            
            // 11. Jarak ke sekolah
            $table->string('distance_km')->nullable();
            $table->string('distance_minutes')->nullable();
            
            // 12. Transportasi
            $table->string('transportation')->nullable();
            
            // 13. Hobi
            $table->string('hobby')->nullable();
            
            // 14. Cita-cita
            $table->string('aspiration')->nullable();
            
            // B. KETERANGAN ORANG TUA/WALI
            // 1. Nama Orang Tua
            $table->string('father_name')->default('-');
            $table->string('mother_name')->default('-');
            
            // 2. Tahun Lahir
            $table->string('father_birth_year')->nullable();
            $table->string('mother_birth_year')->nullable();
            
            // 3. Pendidikan Terakhir
            $table->string('father_education')->nullable();
            $table->string('mother_education')->nullable();
            
            // 4. Pekerjaan
            $table->string('father_job')->nullable();
            $table->string('mother_job')->nullable();
            
            // 5. Penghasilan
            $table->string('father_income')->nullable();
            $table->string('mother_income')->nullable();
            
            // 6. Wali Murid
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('guardian_education')->nullable();
            $table->string('guardian_job')->nullable();
            
            // Kontak
            $table->string('phone');
            $table->string('email')->nullable();
            
            // Status Pendaftaran
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
