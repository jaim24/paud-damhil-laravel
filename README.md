# PAUD Damhil UNG - Sistem Informasi & PPDB Laravel

Aplikasi web manajemen sekolah dan Penerimaan Peserta Didik Baru (PPDB) untuk PAUD Damhil Universitas Negeri Gorontalo. Dibangun menggunakan **Laravel 10**, dilengkapi dengan fitur pembayaran SPP, manajemen siswa/guru, dan tampilan responsif modern.

## 📋 Prasyarat Sistem

Sebelum menginstal, pastikan komputer Anda sudah terinstall:

1.  **PHP** >= 8.1
2.  **Composer** (Manajer paket PHP)
3.  **Database** (MySQL atau MariaDB, bisa via XAMPP/Laragon)
4.  **Node.js & NPM** (Untuk mengompolasi aset CSS/JS)

---

## 🚀 Panduan Instalasi (Langkah demi Langkah)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di komputer lokal Anda:

### 1. Clone Repository (Unduh Kode)

Jika menggunakan Git:
```bash
git clone https://github.com/username/paud-laravel.git
cd paud-laravel
```
*Atau ekstrak file ZIP jika Anda mengunduhnya secara manual.*

### 2. Install Dependensi

Install library PHP dan JavaScript yang dibutuhkan:

```bash
# Install library backend (Laravel)
composer install

# Install library frontend (Vite/Tailwind jika ada)
npm install
```

### 3. Konfigurasi Lingkungan (`.env`)

Duplikat file contoh konfigurasi dan ubah namanya menjadi `.env`:

```bash
copy .env.example .env
```

Buka file `.env` dengan teks editor (Notepad/VS Code) dan atur koneksi database:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paud_laravel  <-- Sesuaikan nama DB Anda
DB_USERNAME=root          <-- Default XAMPP/Laragon biasanya 'root'
DB_PASSWORD=              <-- Kosongkan jika tidak ada password
```

### 4. Buat Database

Buka phpMyAdmin atau HeidiSQL, lalu buat database baru dengan nama yang sesuai dengan di atas (contoh: `paud_laravel`).

### 5. Generate Key & Migrasi Database

Jalankan perintah ini di terminal proyek:

```bash
# Generate kunci enkripsi aplikasi
php artisan key:generate

# Buat tabel-tabel di database otomatis
php artisan migrate
```

### 6. Jalankan Aplikasi

Setelah semua berhasil, jalankan server pengembangan:

```bash
php artisan serve
```

Buka browser dan akses: `http://localhost:8000`

---

## 👤 Membuat Akun Admin

Karena aplikasi ini masih kosong setelah instalasi, Anda perlu membuat akun Admin secara manual lewat terminal (Tinker):

1.  Buka terminal proyek, ketik:
    ```bash
    php artisan tinker
    ```

2.  Copy & Paste perintah berikut (satu per satu):
    ```php
    $admin = new App\Models\User();
    $admin->name = 'Administrator';
    $admin->email = 'admin@paud.com';
    $admin->password = bcrypt('password123'); // Password bisa diganti
    $admin->save();
    ```

3.  Ketik `exit` untuk keluar.
4.  Login di web dengan email `admin@paud.com` dan password `password123`.

---

## 🛠 Teknologi yang Digunakan

-   **Backend**: Laravel 10
-   **Frontend**: Blade Templates, Custom CSS (Glassmorphism UI)
-   **Database**: MySQL
-   **Fitur**:
    -   PPDB Online
    -   Cek Tagihan SPP
    -   Admin Dashboard (Guru, Siswa, Kelas)
    -   Responsive Layout (Mobile & Desktop)

---

## 📄 Lisensi

Proyek ini dibuat khusus untuk PAUD Damhil UNG.
