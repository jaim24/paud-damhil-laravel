<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add attendance settings to settings table (geofencing, work hours)
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Lokasi Sekolah (untuk geofencing)
            $table->decimal('school_latitude', 10, 8)->nullable()->after('registration_fee');
            $table->decimal('school_longitude', 11, 8)->nullable()->after('school_latitude');
            $table->integer('geofence_radius')->default(100)->after('school_longitude'); // dalam meter
            
            // Jam Kerja
            $table->time('work_start_time')->default('07:00:00')->after('geofence_radius');
            $table->time('work_end_time')->default('14:00:00')->after('work_start_time');
            $table->integer('late_tolerance_minutes')->default(30)->after('work_end_time'); // Toleransi terlambat
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'school_latitude',
                'school_longitude',
                'geofence_radius',
                'work_start_time',
                'work_end_time',
                'late_tolerance_minutes',
            ]);
        });
    }
};
