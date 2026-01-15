<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('welcome_text')->default('Selamat Datang di PAUD Damhil UNG');
            $table->text('sub_text')->nullable();
            $table->string('contact_phone')->default('081234567890');
            $table->text('contact_address')->nullable();
            $table->timestamps();
        });

        // Seed default data
        DB::table('settings')->insert([
            'welcome_text' => 'Selamat Datang di PAUD Damhil UNG',
            'sub_text' => 'Membentuk Generasi Cerdas, Ceria, dan Berakhlak Mulia',
            'contact_phone' => '081234567890',
            'contact_address' => 'Jl. Jend. Sudirman No. 123, Gorontalo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
