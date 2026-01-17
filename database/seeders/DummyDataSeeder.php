<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Applicant;
use App\Models\SppInvoice;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ========== GURU ==========
        $teachers = [
            ['name' => 'Hj. Siti Aminah, S.Pd', 'position' => 'Kepala Sekolah', 'education' => 'S1 PAUD', 'status' => 'active'],
            ['name' => 'Nurhaliza Rahman, S.Pd', 'position' => 'Guru Kelas', 'education' => 'S1 PAUD', 'status' => 'active'],
            ['name' => 'Fatimah Zahra, S.Pd', 'position' => 'Guru Kelas', 'education' => 'S1 PAUD', 'status' => 'active'],
            ['name' => 'Dewi Lestari, S.Pd', 'position' => 'Guru Pendamping', 'education' => 'S1 PAUD', 'status' => 'active'],
            ['name' => 'Ahmad Hidayat', 'position' => 'Tenaga Administrasi', 'education' => 'SMA', 'status' => 'active'],
        ];
        
        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        // ========== KELAS ==========
        $classes = [
            ['name' => 'Kelas A1', 'age_group' => '3-4 Tahun', 'academic_year' => '2025/2026'],
            ['name' => 'Kelas A2', 'age_group' => '3-4 Tahun', 'academic_year' => '2025/2026'],
            ['name' => 'Kelas B1', 'age_group' => '5-6 Tahun', 'academic_year' => '2025/2026'],
            ['name' => 'Kelas B2', 'age_group' => '5-6 Tahun', 'academic_year' => '2025/2026'],
        ];
        
        foreach ($classes as $class) {
            SchoolClass::create($class);
        }

        // ========== SISWA ==========
        $students = [
            ['nisn' => '00112233001', 'name' => 'Aisyah Putri Rahmah', 'class_group' => 'Kelas A1', 'gender' => 'P', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Ahmad Rahmah', 'parent_phone' => '081234567001'],
            ['nisn' => '00112233002', 'name' => 'Muhammad Rizki Pratama', 'class_group' => 'Kelas A1', 'gender' => 'L', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Budi Pratama', 'parent_phone' => '081234567002'],
            ['nisn' => '00112233003', 'name' => 'Nabila Azzahra', 'class_group' => 'Kelas A1', 'gender' => 'P', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Dedi Azzahra', 'parent_phone' => '081234567003'],
            ['nisn' => '00112233004', 'name' => 'Fajar Ramadhan', 'class_group' => 'Kelas A2', 'gender' => 'L', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Eko Ramadhan', 'parent_phone' => '081234567004'],
            ['nisn' => '00112233005', 'name' => 'Zahra Khairina', 'class_group' => 'Kelas A2', 'gender' => 'P', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Farid Khairina', 'parent_phone' => '081234567005'],
            ['nisn' => '00112233006', 'name' => 'Ahmad Zidan', 'class_group' => 'Kelas B1', 'gender' => 'L', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Gunawan Zidan', 'parent_phone' => '081234567006'],
            ['nisn' => '00112233007', 'name' => 'Siti Khadijah', 'class_group' => 'Kelas B1', 'gender' => 'P', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Hasan Khadijah', 'parent_phone' => '081234567007'],
            ['nisn' => '00112233008', 'name' => 'Ridwan Hakim', 'class_group' => 'Kelas B1', 'gender' => 'L', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Irwan Hakim', 'parent_phone' => '081234567008'],
            ['nisn' => '00112233009', 'name' => 'Nurul Izzah', 'class_group' => 'Kelas B2', 'gender' => 'P', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Joko Izzah', 'parent_phone' => '081234567009'],
            ['nisn' => '00112233010', 'name' => 'Hafiz Abdullah', 'class_group' => 'Kelas B2', 'gender' => 'L', 'academic_year' => '2025/2026', 'status' => 'active', 'parent_name' => 'Karim Abdullah', 'parent_phone' => '081234567010'],
        ];
        
        foreach ($students as $student) {
            Student::create($student);
        }

        // ========== PENDAFTAR SPMB (Schema baru dengan biodata lengkap) ==========
        $applicants = [
            [
                'child_name' => 'Amira Safitri', 
                'birth_place' => 'Gorontalo',
                'birth_date' => '2022-01-15', 
                'gender' => 'P',
                'religion' => 'Islam',
                'father_name' => 'Budi Santoso', 
                'mother_name' => 'Siti Aminah',
                'phone' => '081234567890', 
                'address_street' => 'Jl. Sudirman No. 10, Gorontalo', 
                'status' => 'Pending', 
                'created_at' => Carbon::now()->subDays(2)
            ],
            [
                'child_name' => 'Raka Pratama', 
                'birth_place' => 'Gorontalo',
                'birth_date' => '2022-03-22', 
                'gender' => 'L',
                'religion' => 'Islam',
                'father_name' => 'Ahmad Rahmawati', 
                'mother_name' => 'Siti Rahmawati',
                'phone' => '081234567891', 
                'address_street' => 'Jl. Ahmad Yani No. 5, Gorontalo', 
                'status' => 'Pending', 
                'created_at' => Carbon::now()->subDays(5)
            ],
            [
                'child_name' => 'Dina Kusuma', 
                'birth_place' => 'Gorontalo',
                'birth_date' => '2022-02-10', 
                'gender' => 'P',
                'religion' => 'Islam',
                'father_name' => 'Ahmad Kusuma', 
                'mother_name' => 'Dewi Kusuma',
                'phone' => '081234567892', 
                'address_street' => 'Jl. Pemuda No. 15, Gorontalo', 
                'status' => 'Accepted', 
                'created_at' => Carbon::now()->subDays(10)
            ],
            [
                'child_name' => 'Faiz Rahman', 
                'birth_place' => 'Gorontalo',
                'birth_date' => '2022-05-18', 
                'gender' => 'L',
                'religion' => 'Islam',
                'father_name' => 'Rahman Hidayat', 
                'mother_name' => 'Nur Hidayah',
                'phone' => '081234567893', 
                'address_street' => 'Jl. Merdeka No. 8, Gorontalo', 
                'status' => 'Accepted', 
                'created_at' => Carbon::now()->subDays(15)
            ],
            [
                'child_name' => 'Salwa Aulia', 
                'birth_place' => 'Gorontalo',
                'birth_date' => '2022-04-05', 
                'gender' => 'P',
                'religion' => 'Islam',
                'father_name' => 'Aulia Putra', 
                'mother_name' => 'Aulia Dewi',
                'phone' => '081234567894', 
                'address_street' => 'Jl. Pahlawan No. 20, Gorontalo', 
                'status' => 'Rejected', 
                'created_at' => Carbon::now()->subMonths(1)
            ],
        ];
        
        foreach ($applicants as $applicant) {
            Applicant::create($applicant);
        }

        // ========== SPP INVOICES ==========
        $students = Student::all();
        $months = ['Januari 2026', 'Februari 2026', 'Maret 2026', 'April 2026', 'Mei 2026', 'Juni 2026'];
        
        foreach ($students as $student) {
            foreach ($months as $month) {
                $isPaid = rand(0, 1);
                DB::table('spp_invoices')->insert([
                    'nisn' => $student->nisn,
                    'student_name' => $student->name,
                    'month' => $month,
                    'amount' => 350000,
                    'status' => $isPaid ? 'Paid' : 'Unpaid',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ========== GALERI ==========
        $galleries = [
            ['title' => 'Kegiatan Menari Bersama', 'description' => 'Anak-anak belajar menari tarian tradisional', 'image' => 'galleries/dance.jpg', 'event_date' => Carbon::now()->subDays(5), 'is_active' => true, 'show_on_home' => true],
            ['title' => 'Lomba Mewarnai', 'description' => 'Lomba mewarnai dalam rangka hari kemerdekaan', 'image' => 'galleries/coloring.jpg', 'event_date' => Carbon::now()->subDays(10), 'is_active' => true, 'show_on_home' => true],
            ['title' => 'Outing Class ke Kebun Binatang', 'description' => 'Kunjungan edukatif ke kebun binatang', 'image' => 'galleries/zoo.jpg', 'event_date' => Carbon::now()->subDays(20), 'is_active' => true, 'show_on_home' => true],
        ];
        
        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }

        // ========== BERITA ==========
        $news = [
            ['title' => 'Pendaftaran SPMB Tahun Ajaran 2026/2027 Dibuka', 'summary' => 'Pendaftaran siswa baru telah dibuka', 'content' => 'PAUD Damhil UNG membuka pendaftaran siswa baru untuk tahun ajaran 2026/2027. Segera daftarkan putra-putri Anda!', 'category' => 'pengumuman', 'status' => 'published', 'show_on_home' => true, 'published_date' => Carbon::now()->subDays(3)],
            ['title' => 'Libur Semester Genap', 'summary' => 'Pengumuman libur semester genap', 'content' => 'Diberitahukan kepada seluruh wali murid bahwa libur semester genap dimulai tanggal 20 Juni 2026.', 'category' => 'pengumuman', 'status' => 'published', 'show_on_home' => true, 'published_date' => Carbon::now()->subDays(7)],
            ['title' => 'Jadwal Vaksinasi Anak', 'summary' => 'Vaksinasi bersama Puskesmas', 'content' => 'Akan dilaksanakan vaksinasi bersama Puskesmas pada tanggal 25 Januari 2026.', 'category' => 'berita', 'status' => 'published', 'show_on_home' => true, 'published_date' => Carbon::now()->subDays(14)],
        ];
        
        foreach ($news as $item) {
            News::create($item);
        }

        $this->command->info('✅ Data dummy berhasil dibuat!');
    }
}
