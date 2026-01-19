<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();

        if ($teachers->isEmpty()) {
            $this->command->info('Tidak ada data guru. Jalankan DummyDataSeeder terlebih dahulu.');
            return;
        }

        // Generate attendance for the last 3 months
        $startDate = Carbon::now()->subMonths(2)->startOfMonth();
        $endDate = Carbon::now();

        $statusOptions = ['hadir', 'hadir', 'hadir', 'hadir', 'terlambat', 'izin', 'sakit']; // weighted towards 'hadir'

        $this->command->info("Generating attendance data from {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}...");

        $count = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            foreach ($teachers as $teacher) {
                // 90% chance teacher has attendance record
                if (rand(1, 100) <= 90) {
                    $status = $statusOptions[array_rand($statusOptions)];
                    
                    $checkIn = null;
                    $checkOut = null;
                    
                    if (in_array($status, ['hadir', 'terlambat'])) {
                        // Generate check-in time
                        if ($status === 'hadir') {
                            // On time: 06:30 - 07:30
                            $checkIn = sprintf('%02d:%02d:00', rand(6, 7), rand(0, 30));
                        } else {
                            // Late: 07:31 - 09:00
                            $checkIn = sprintf('%02d:%02d:00', rand(7, 9), rand(31, 59));
                        }
                        
                        // 80% chance has check-out
                        if (rand(1, 100) <= 80) {
                            // Check-out: 13:00 - 16:00
                            $checkOut = sprintf('%02d:%02d:00', rand(13, 16), rand(0, 59));
                        }
                    }

                    Attendance::updateOrCreate(
                        [
                            'teacher_id' => $teacher->id,
                            'date' => $date->format('Y-m-d'),
                        ],
                        [
                            'check_in' => $checkIn,
                            'check_out' => $checkOut,
                            'status' => $status,
                            'notes' => null,
                        ]
                    );
                    
                    $count++;
                }
            }
        }

        $this->command->info("Created {$count} attendance records for {$teachers->count()} teachers.");
    }
}
