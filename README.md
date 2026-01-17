<p align="center">
  <img src="public/images/logo.png" alt="PAUD Damhil Logo" width="120" height="120">
</p>

<h1 align="center">🎓 PAUD Damhil UNG</h1>

<p align="center">
  <strong>Sistem Informasi Sekolah & SPMB (Seleksi Penerimaan Murid Baru)</strong>
</p>

<p align="center">
  <a href="#-fitur-unggulan">Fitur</a> •
  <a href="#-teknologi">Teknologi</a> •
  <a href="#-instalasi">Instalasi</a> •
  <a href="#-screenshot">Screenshot</a> •
  <a href="#-kontribusi">Kontribusi</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Active%20Development-brightgreen?style=flat-square" alt="Status">
  <img src="https://img.shields.io/badge/License-Educational-blue?style=flat-square" alt="License">
</p>

---

## 🌟 Tentang Proyek

**PAUD Damhil UNG** adalah sistem informasi sekolah modern yang dibangun khusus untuk PAUD Damhil Universitas Negeri Gorontalo. Aplikasi ini menyediakan solusi lengkap untuk manajemen sekolah PAUD, mulai dari pendaftaran siswa baru hingga pengelolaan pembayaran SPP.

### ✨ Mengapa Memilih Sistem Ini?

- 🎨 **UI/UX Modern** - Desain glassmorphism yang cantik dan responsif
- 📱 **Mobile Friendly** - Tampilan optimal di semua perangkat
- 🔐 **Aman** - Sistem token untuk pendaftaran, mencegah spam
- 📊 **Dashboard Lengkap** - Statistik dan laporan real-time
- 🚀 **Performa Tinggi** - Dibangun dengan Laravel terbaru

---

## 🎯 Fitur Unggulan

<table>
<tr>
<td width="50%">

### 📝 SPMB Online
- Pendaftaran dengan sistem token akses
- Formulir biodata lengkap & terstruktur
- Daftar tunggu otomatis saat kuota penuh
- Cek status pendaftaran real-time

</td>
<td width="50%">

### 👨‍🎓 Manajemen Siswa
- Data siswa per kelas dengan statistik
- Filter & pencarian cerdas
- Tracking status (Aktif/Lulus/Nonaktif)
- Info orang tua terintegrasi

</td>
</tr>
<tr>
<td width="50%">

### 💰 Kelola SPP
- Tagihan per siswa terorganisir per kelas
- Buat tagihan massal dengan 1 klik
- Status pembayaran real-time
- Riwayat pembayaran lengkap

</td>
<td width="50%">

### 👩‍🏫 Data Guru & Kelas
- Profil guru lengkap
- Manajemen kelas dinamis
- Alokasi wali kelas
- Tahun ajaran fleksibel

</td>
</tr>
<tr>
<td width="50%">

### 🖼️ Galeri Foto
- Upload foto kegiatan sekolah
- Organisasi per album
- Tampilan grid responsif
- Lightbox preview

</td>
<td width="50%">

### 📊 Dashboard Admin
- Statistik pendaftaran
- Grafik pembayaran SPP
- Notifikasi pendaftar baru
- Quick actions

</td>
</tr>
</table>

---

## 🛠️ Teknologi

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 12, PHP 8.3 |
| **Frontend** | Blade Templates, TailwindCSS, Alpine.js |
| **Database** | MySQL / MariaDB |
| **Icons** | Phosphor Icons |
| **Charts** | Chart.js |
| **Auth** | Laravel Built-in Auth |

---

## 📸 Screenshot

<p align="center">
  <img src="docs/screenshots/homepage.png" alt="Homepage" width="45%">
  <img src="docs/screenshots/dashboard.png" alt="Dashboard" width="45%">
</p>

<p align="center">
  <img src="docs/screenshots/spmb-form.png" alt="Form SPMB" width="45%">
  <img src="docs/screenshots/students.png" alt="Data Siswa" width="45%">
</p>

> 💡 *Screenshot akan ditambahkan setelah deployment*

---

## 🚀 Instalasi

### Prasyarat

Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/paud-laravel.git
cd paud-laravel

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

# 5. Migrasi database
php artisan migrate

# 6. (Opsional) Seed data dummy
php artisan db:seed

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

🌐 Akses: `http://localhost:8000`

---

## 👤 Akun Default

Setelah instalasi dengan seeder:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@pauddamhil.sch.id | admin123 |

> ⚠️ **Penting:** Ganti password default setelah login pertama!

---

## 📁 Struktur Proyek

```
paud-laravel/
├── app/
│   ├── Http/Controllers/   # Logic aplikasi
│   ├── Models/             # Model Eloquent
│   └── ...
├── database/
│   ├── migrations/         # Struktur database
│   └── seeders/           # Data dummy
├── resources/
│   ├── views/             # Template Blade
│   └── css/               # Styling
├── routes/
│   └── web.php            # Definisi routes
└── public/                # Assets publik
```

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📞 Kontak

**PAUD Damhil - Universitas Negeri Gorontalo**

- 🌐 Website: [Coming Soon]
- 📧 Email: info@pauddamhil.sch.id
- 📍 Lokasi: Kampus UNG, Gorontalo

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan pendidikan PAUD Damhil UNG.

---

<p align="center">
  Made with ❤️ for PAUD Damhil UNG
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Built%20with-Laravel-FF2D20?style=for-the-badge&logo=laravel" alt="Built with Laravel">
</p>
