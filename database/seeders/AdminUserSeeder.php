<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('email', 'admin@pauddamhil.sch.id')->exists();
        
        if (!$adminExists) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@pauddamhil.sch.id',
                'password' => Hash::make('admin123'),
            ]);
            
            $this->command->info('✅ Akun Admin berhasil dibuat!');
            $this->command->info('   Email: admin@pauddamhil.sch.id');
            $this->command->info('   Password: admin123');
        } else {
            $this->command->info('ℹ️ Akun Admin sudah ada, skip...');
        }
    }
}
