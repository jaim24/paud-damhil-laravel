<p align="center">
  <img src="public/images/logo.png" alt="PAUD Logo" width="120" height="120">
</p>

<h1 align="center">🎓 Sistem Informasi Sekolah PAUD (SIMS)</h1>

<p align="center">
  <strong>Platform Terintegrasi untuk Manajemen Sekolah, Absensi, & Penerimaan Siswa Baru</strong>
</p>

<p align="center">
  <a href="#-fitur-unggulan">Fitur</a> •
  <a href="#-teknologi">Teknologi</a> •
  <a href="#-instalasi">Instalasi</a> •
  <a href="#-screenshot">Screenshot</a> •
  <a href="#-kontribusi">Kontribusi</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Active%20Development-brightgreen?style=flat-square" alt="Status">
  <img src="https://img.shields.io/badge/License-MIT-blue?style=flat-square" alt="License">
</p>

---

## 🌟 Tentang Proyek

**Sistem Informasi Sekolah PAUD (SIMS)** adalah solusi aplikasi berbasis web dan API mobile yang dirancang untuk memodernisasi pengelolaan sekolah PAUD/TK. Aplikasi ini mencakup manajemen data siswa, guru, kelas, keuangan (SPP), hingga absensi guru berbasis geofencing.

### ✨ Mengapa Menggunakan Sistem Ini?

- 🎨 **UI/UX Modern** - Desain bersih dan responsif menggunakan TailwindCSS.
- 📱 **API Ready** - Endpoint API siap pakai untuk integrasi aplikasi mobile (Flutter/Android).
- 📍 **Absensi Geofencing** - Sistem validasi lokasi GPS untuk kehadiran guru.
- 🔐 **Secure** - Auth menggunakan Laravel Sanctum & built-in security features.
- 📊 **Dashboard Lengkap** - Statistik real-time untuk kepala sekolah.

---

## 🎯 Fitur Unggulan

<table>
<tr>
<td width="50%">

### 📝 SPMB Online

- Pendaftaran siswa baru online
- Sistem token akses unik
- Manajemen pendaftar & status seleksi
- Export data pendaftar

</td>
<td width="50%">

### 👨‍🎓 Manajemen Akademik

- Data induk siswa & guru
- Manajemen kelas & tahun ajaran
- Kenaikan kelas & status siswa
- Riwayat pendidikan guru

</td>
</tr>
<tr>
<td width="50%">

### 💰 Keuangan & SPP

- Tagihan SPP otomatis per kelas
- Riwayat pembayaran & tunggakan
- Laporan keuangan sederhana
- Kwitansi digital

</td>
<td width="50%">

### 📍 Absensi Guru (Geofencing)

- Validasi lokasi (Latitude/Longitude)
- Radius toleransi yang dapat diatur
- Rekap kehadiran otomatis
- Pengajuan izin/sakit

</td>
</tr>
</table>

---

## 🛠️ Teknologi Stack

| Komponen | Teknologi |
|----------|-----------|
| **Framework** | Laravel 11.x |
| **Language** | PHP 8.2+ |
| **Frontend** | Blade, TailwindCSS, Alpine.js |
| **API Auth** | Laravel Sanctum |
| **Database** | MySQL / MariaDB |
| **Icons** | Phosphor Icons |

---

## 🚀 Instalasi

### Prasyarat

Pastikan server Anda memenuhi syarat:

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/paud-sims.git
cd paud-sims

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=paud_laravel
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Migrasi database & Seeding
php artisan migrate --seed

# 6. Build assets frontend
npm run build

# 7. Jalankan server (Local)
php artisan serve
```

🌐 Akses Web: `http://localhost:8000`
📱 Akses API: `http://localhost:8000/api`

---

## 👤 Akun Default (Seeder)

Jika menggunakan `php artisan migrate --seed`:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@sekolah.sch.id` | `password` |

> ⚠️ **Catatan:** Password untuk user Guru dapat diatur melalui dashboard admin.

---

## 📁 Struktur API (Sekilas)

Aplikasi ini menyediakan REST API untuk integrasi Mobile Apps:

- `POST /api/login` - Autentikasi Guru
- `POST /api/absensi` - Chek-in/Check-out dengan GPS
- `GET /api/absensi/history` - Riwayat kehadiran
- `POST /api/izin` - Pengajuan izin/sakit
- `GET /api/settings` - Konfigurasi lokasi sekolah

---

## 🤝 Kontribusi

Proyek ini terbuka untuk kontribusi (Open Source). Silakan fork dan buat Pull Request untuk fitur baru atau perbaikan bug.

---

## 📄 Lisensi

MIT License. Silakan gunakan dan modifikasi untuk keperluan sekolah Anda sendiri.

---

<p align="center">
  <img src="https://img.shields.io/badge/Built%20with-Laravel-FF2D20?style=for-the-badge&logo=laravel" alt="Built with Laravel">
</p>
