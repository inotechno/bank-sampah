<h1 align="center">Bank Sampah Kalkulator</h1>

Bank Sampah Kalkulator adalah aplikasi web berbasis Laravel + Livewire 3 yang membantu warga menghitung nilai setoran sampah secara cepat dan memudahkan administrator bank sampah dalam mengelola daftar jenis sampah, harga per kilogram, serta informasi pendukung lainnya.

## ✨ Fitur Utama

- **Kalkulator Interaktif** – Pengguna dapat memilih beberapa jenis sampah sekaligus, memasukkan berat dalam kilogram, dan langsung melihat estimasi nilai yang diterima.
- **Rekomendasi Otomatis** – Sistem menampilkan rekomendasi jenis sampah dengan harga tertinggi yang belum dipilih pengguna.
- **Manajemen Jenis Sampah (Admin)** – Tambah, ubah, hapus, unggah foto, dan atur status aktif/tidak aktif dengan konfirmasi aman menggunakan Livewire Alert.
- **Dashboard Administratif** – Ringkasan singkat mengenai jumlah jenis sampah beserta rata-rata harga per kilogram.
- **Antarmuka Responsif** – Tampilan bersih dan modern dengan dukungan tema hijau khas bank sampah.

## 🛠️ Teknologi

- Laravel 12 + PHP 8.2
- Livewire 3 & Volt
- Tailwind CSS
- SweetAlert2 (jantinnerezo/livewire-alert)
- MySQL / MariaDB

## 🚀 Langkah Instalasi

1. **Klon repositori & masuk ke direktori proyek**
   ```bash
   git clone <repo-url> bank-sampah
   cd bank-sampah
   ```

2. **Instal dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Salin berkas environment & generate key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database** – Sesuaikan nilai `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env` untuk MySQL.

5. **Migrasi & seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symlink storage untuk menampilkan gambar**
   ```bash
   php artisan storage:link
   ```

7. **Build aset front-end (pilih salah satu)**
   ```bash
   # Mode development dengan hot reload
   npm run dev

   # Atau build production
   npm run build
   ```

8. **Menjalankan aplikasi**
   ```bash
   # Opsi 1: menggunakan PHP dan Vite
   php artisan serve
   npm run dev

   # Opsi 2: menggunakan Docker (direkomendasikan)
   docker compose up -d
   ```

## 🔐 Akun Admin Bawaan

- Email: `admin@banksampah.test`
- Password: `password`

Anda dapat mengubah kredensial tersebut melalui halaman profil setelah login.

## 🧭 Panduan Penggunaan Singkat

- **Pengguna**: Akses beranda (`/`), pilih jenis sampah, masukkan berat, lalu tekan *Hitung Total*. Ringkasan hasil dan rekomendasi akan muncul di sisi kanan.
- **Admin**: Login melalui `/login`, lalu buka menu *Jenis Sampah* untuk mengelola data. Unggah foto, atur harga, dan aktif/nonaktifkan jenis sesuai kebutuhan.

## 📋 Panduan Detail Fitur Admin

### 1. Manajemen Jenis Sampah
- Akses halaman `Dashboard > Jenis Sampah` setelah login sebagai admin.
- Gunakan kolom pencarian untuk memfilter berdasarkan nama atau deskripsi.
- Tombol **Jenis Baru** membuka formulir penambahan lengkap dengan unggah foto.
- Saat mengedit:
  - Harga otomatis diformat 2 angka desimal.
  - Foto lama akan diganti jika Anda mengunggah file baru.
  - Opsi *Tampilkan di kalkulator pengguna* mengatur status aktif.
- Tombol **Hapus** memunculkan konfirmasi (Livewire Alert) sebelum data benar‑benar dihapus.

### 2. Upload & Penyimpanan Foto
- File disimpan di `storage/app/public/waste-types` dan diakses via `Storage::url`.
- Jalankan `php artisan storage:link` sekali agar gambar tersedia di publik.
- Format yang diterima: `jpg`, `jpeg`, `png`, `webp` dengan ukuran maksimum 2 MB.

### 3. Navigasi & Akses
- Middleware `auth`, `verified`, dan `admin` melindungi semua rute admin.
- Pengguna non-admin yang mencoba mengakses halaman admin akan mendapatkan status HTTP 403.
- Navigasi Livewire otomatis menampilkan link *Jenis Sampah* hanya untuk admin.

## 🧮 Alur Kerja Kalkulator Pengguna

1. Komponen Livewire `WasteCalculator` tampil di beranda.
2. Data jenis sampah diambil dari tabel `waste_types` (hanya yang aktif) dan di-cache di properti komponen.
3. Pengguna dapat menambah baris entri tanpa batas:
   - Field berat hanya menerima angka positif (0.1 hingga 1000 kg).
   - Total dihitung otomatis setiap kali entri berubah.
4. Panel samping menampilkan ringkasan serta rekomendasi tiga jenis dengan harga tertinggi yang belum dipilih.

## 🧪 Pengujian

Jalankan seluruh test menggunakan perintah:

```bash
php artisan test
```

> **Catatan:** PHPUnit bawaan menggunakan koneksi SQLite in-memory. Pastikan ekstensi `pdo_sqlite` aktif di PHP lokal, atau konfigurasi `phpunit.xml` agar menggunakan koneksi MySQL jika ekstensi tersebut tidak tersedia.

## 📄 Lisensi

Proyek ini dirilis sebagai perangkat lunak open-source di bawah lisensi [MIT](LICENSE).
