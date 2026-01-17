<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Selalu jalankan AdminUserSeeder terlebih dahulu
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
