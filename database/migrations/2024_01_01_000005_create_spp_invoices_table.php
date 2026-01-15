<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spp_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nisn'); // Link to students.nisn manually
            $table->string('student_name'); // Denormalized for info
            $table->string('month');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('Unpaid');
            $table->timestamps();
        });

        // Seed sample
        DB::table('spp_invoices')->insert([
            'nisn' => '12345',
            'student_name' => 'Budi Santoso',
            'month' => 'Januari 2026',
            'amount' => 150000,
            'status' => 'Unpaid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('spp_invoices');
    }
};
