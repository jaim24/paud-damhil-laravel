<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class AttendanceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = Setting::first() ?? new Setting();
        
        $settings->school_name = $settings->school_name ?? 'PAUD Pintar';
        
        // Data sesuai request user
        $settings->school_latitude = -6.175110;
        $settings->school_longitude = 106.827220;
        $settings->geofence_radius = 100; // max_distance
        $settings->work_start_time = '07:00:00'; // start_time
        $settings->work_end_time = '14:00:00'; // end_time
        $settings->late_tolerance_minutes = 30;
        
        $settings->save();
    }
}
