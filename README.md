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

## 🧪 Pengujian

Jalankan seluruh test menggunakan perintah:

```bash
php artisan test
```

## 📄 Lisensi

Proyek ini dirilis sebagai perangkat lunak open-source di bawah lisensi [MIT](LICENSE).
