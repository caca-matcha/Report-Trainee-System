# Manuskrip & Dokumentasi Teknikal (Handover Manual Book)

**Report Trainee System** — Platform Manajemen Pelatihan & Sertifikasi Karyawan
**PT Dharma Polimetal Tbk.**

---

### Developed By:
**Antigravity AI (Coding Assistant)**
Departmen/Tim HRMS – PT Dharma Polimetal Tbk.

---

## Daftar Isi
1. [Pendahuluan](#1-pendahuluan)
2. [Teknologi & Stack (Tech Stack)](#2-teknologi--stack)
3. [Arsitektur & Struktur Direktori](#3-arsitektur--struktur-direktori)
4. [Struktur Database & Entitas (Models)](#4-struktur-database--entitas)
5. [Alur Bisnis Proses (Workflow)](#5-alur-bisnis-proses)
6. [Panduan Instalasi & Pengembangan](#6-panduan-instalasi--pengembangan)
7. [Testing (Pengujian)](#7-testing)
8. [Panduan Maintenance & Troubleshooting](#8-panduan-maintenance--troubleshooting)
9. [Catatan Handover & Known Issues](#9-catatan-handover)
10. [Informasi Lingkungan Produksi & Kontak Darurat](#10-informasi-kontak-darurat)

---

## 1. Pendahuluan
Dokumen ini disusun sebagai panduan **Technical Handover** untuk pengembang (developer) yang akan melanjutkan, memelihara, atau menambah fitur di dalam aplikasi **Report Trainee System**. Dokumen ini merangkum arsitektur, teknologi, serta aliran proses bisnis yang telah diimplementasikan, guna mempercepat proses adaptasi (*onboarding*) tim IT yang baru di PT Dharma Polimetal Tbk.

## 2. Teknologi & Stack
Aplikasi ini berjalan secara spesifik menggunakan stack teknologi yang stabil:
- **Backend**: PHP ^8.2 & Framework **Laravel 12**
- **Frontend CSS**: **Tailwind CSS v3** (dikompilasi menggunakan Vite)
- **Frontend Interaktif**:
    - **Alpine.js** (Untuk interaksi UI DOM dinamis pada template Blade)
    - **Lucide Icons** (Set ikon sistem yang konsisten)
- **Database**: **MySQL/MariaDB**
- **Libraries Utama**:
    - `maatwebsite/excel`: Manajemen Import/Export data Master dan Skor.
    - `simplesoftwareio/simple-qrcode`: Pembangkit QR Code untuk sistem presensi.
- **Dependency Manager**: Composer (PHP) & NPM (JavaScript)

## 3. Arsitektur & Struktur Direktori
Sistem mengikuti struktur standar Laravel 12:
- `app/Http/Controllers/`: Logika bisnis. Terbagi menjadi folder `Admin/` untuk fitur manajerial.
- `app/Models/`: Definisi entitas dan relasi database (Eloquents).
- `routes/web.php`: Pusat navigasi route, dipisahkan antara akses Publik (Signed URL) dan Admin.
- `resources/views/`: File template menggunakan Blade. Terstruktur dalam folder `admin/`, `components/`, dan `layouts/`.

## 4. Struktur Database & Entitas
Terdapat beberapa tabel penopang utama sistem yang tersimpan di `app/Models/`:
1. **User**: Mengelola data autentikasi dan role akses.
2. **MasterTraining**: Definisi template program pelatihan (Category, Event No, Training Topic).
3. **Training**: Unit eksekusi pelatihan (Batch) yang memiliki jadwal dan PIC tertentu.
4. **TrainingParticipant**: Menghubungkan peserta dengan sesi pelatihan, mencakup data presensi dan skor.
5. **TrainingSummary**: Menampung hasil akhir pelatihan untuk pelaporan.
6. **TrainingEvaluation & Atmosphere**: Mencatat feedback peserta dan evaluasi lingkungan belajar.

## 5. Alur Bisnis Proses (Workflow)
### a. Manajemen Master Pelatihan
Setiap program pelatihan baru harus didaftarkan di Master Training. Admin dapat melakukan import massal via CSV/Excel untuk mempercepat input database.

### b. Eksekusi Pelatihan
Sesi pelatihan baru (Batch) dibuat dengan mereferensikan Master Training. Sistem akan mengunci kode training secara otomatis (Auto-increment berdasarkan kategori).

### c. Presensi & Monitoring
Trainee mencatat kehadiran dengan melakukan pemindaian QR Code yang bersifat unik per sesi. Data kehadiran tersinkronisasi secara *real-time* ke dashboard Admin.

## 6. Panduan Instalasi & Pengembangan
Lakukan tahapan berikut di lingkungan terminal:
```bash
# 1. Install library backend
composer install

# 2. Persiapan variabel environment
cp .env.example .env
php artisan key:generate

# 3. Eksekusi Skema Database
# (Sesuaikan DB_DATABASE di .env terlebih dahulu)
php artisan migrate --seed

# 4. Install dependensi frontend & Build
npm install
npm run build # Untuk produksi
npm run dev   # Untuk mode pengembangan
```

## 7. Testing (Pengujian)
Sistem ini menggunakan framework pengujian standar Laravel.
- Jalankan perintah `php artisan test` untuk menjalankan seluruh skenario pengujian unit dan fitur.
- Code style dipandu menggunakan `Laravel Pint` untuk menjaga konsistensi sintaksis.

## 8. Panduan Maintenance & Troubleshooting
- **Vite Manifest Not Found**: Jalankan `npm run build` jika aset CSS tidak muncul di sistem production.
- **Cache Refresh**: Gunakan `php artisan optimize:clear` jika perubahan route atau view tidak langsung terlihat.
- **Logo Update**: Logo sistem tersimpan di `public/assets/dg-logo.png`. Pastikan path ini benar saat melakukan pembaruan branding.

## 9. Catatan Handover & Known Issues
- **Signature & Barcode**: PDF Report menggunakan layout fix untuk menjaga stabilitas penempatan tanda tangan dan barcode.
- **GS Integration**: Beberapa modul evaluasi mendukung penarikan data otomatis dari Google Sheets.

## 10. Informasi Lingkungan Produksi & Kontak Darurat
**PENGEMBANG APLIKASI**
- **Sistem**: Report Trainee System
- **Instansi**: PT Dharma Polimetal Tbk.

**KONTAK DARURAT (SUPPORT)**
Apabila terjadi kendala kritis pada sistem, silakan koordinasikan melalui internal IT Departmen atau Tim HRMS PT Dharma Polimetal Tbk.

---
*Report Trainee System © PT Dharma Polimetal Tbk.*
*Dokumen ini disesuaikan dengan arsitektur source code status terkini (April 2026).*
