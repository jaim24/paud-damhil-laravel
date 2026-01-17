<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();
            // Data Anak
            $table->string('child_name');
            $table->string('birth_place')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P'])->default('L');
            // Data Ayah
            $table->string('father_name');
            $table->string('father_job')->nullable();
            // Data Ibu
            $table->string('mother_name');
            $table->string('mother_job')->nullable();
            // Kontak
            $table->text('address');
            $table->string('phone');
            $table->text('notes')->nullable();
            // Status
            $table->enum('status', ['waiting', 'transferred', 'cancelled'])->default('waiting');
            $table->timestamp('transferred_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
};
