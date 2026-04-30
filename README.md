# 📚 Sistem Ujian Online (Exam System)

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/Lisensi-MIT-green.svg)](LICENSE)

**Sistem ujian online lengkap dengan perlindungan anti-curang, manajemen siswa, dan dashboard monitoring real-time.**

---

## 📌 Tentang Proyek

Sistem Ujian Online adalah platform berbasis web yang dirancang untuk sekolah dan institusi dalam melaksanakan ujian secara online. Sistem ini dilengkapi dengan deteksi anti-curang yang kuat, pengelompokan siswa berdasarkan kelas, monitoring pelanggaran real-time, serta dashboard admin yang intuitif.

---

## ✨ Fitur Utama

### 👨‍🎓 Untuk Siswa

| Fitur | Keterangan |
|-------|------------|
| **Login Aman** | Autentikasi menggunakan NIS dan Password |
| **Masukkan Kode Ujian** | Masukkan kode unik untuk mengakses ujian |
| **Iframe Ujian** | Integrasi dengan Microsoft Forms / Google Forms |
| **Timer Countdown** | Pelacak waktu ujian real-time |
| **Sistem Anti-Curang** | Berbagai mekanisme deteksi kecurangan |
| **Peringatan Visual** | Alert saat terdeteksi aktivitas mencurigakan |
| **Kode Aktivasi** | Minta kode 5 digit ke admin jika ujian terkunci |
| **Riwayat Ujian** | Lihat riwayat ujian yang pernah dikerjakan |

### 👨‍💼 Untuk Admin / Guru

| Fitur | Keterangan |
|-------|------------|
| **Dashboard Statistik** | Data lengkap tentang ujian dan siswa |
| **Manajemen Siswa** | CRUD siswa + pengelompokan berdasarkan kelas |
| **Manajemen Ujian** | CRUD ujian dengan dukungan iframe/URL |
| **Monitoring Sesi** | Pantau sesi ujian yang sedang berlangsung |
| **Log Pelanggaran** | Catatan lengkap pelanggaran siswa |
| **Generate Kode Aktivasi** | Buat kode 5 digit untuk membuka ujian terkunci |
| **Filter Data** | Filter berdasarkan kelas |
| **Export Data** | Ekspor data ke CSV |

---

## 🛡️ Fitur Anti-Curang

### Deteksi Aktif

| No | Pelanggaran | Keterangan |
|----|-------------|------------|
| 1 | Pindah Tab/Window | Terdeteksi saat siswa berpindah ke tab lain |
| 2 | Minimize Halaman | Terdeteksi saat halaman diminimize |
| 3 | Klik Kanan | Mencegah klik kanan (context menu) |
| 4 | DevTools (F12) | Mencegah pembukaan Developer Tools |
| 5 | Copy/Paste | Mencegah copy dan paste teks |
| 6 | Refresh (F5/Ctrl+R) | Mencegah refresh halaman |
| 7 | Screenshot (PrintScreen) | Mendeteksi screenshot |
| 8 | Split Screen | Mendeteksi layar belah / split screen |
| 9 | Pop Up Aplikasi | Mendeteksi membuka aplikasi lain |
| 10 | Inactivity | Mendeteksi ketidakaktifan terlalu lama |
| 11 | Tombol Back | Mencegah tombol back browser |
| 12 | Tombol Back Android | Mencegah tombol back perangkat Android |

### Sistem Strike

- **Pelanggaran** → Strike +1
- **3 Strikes** → Ujian otomatis terkunci
- **Kode Aktivasi** → Admin dapat memberikan kode untuk membuka kunci

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Keterangan |
|-----------|------------|
| Laravel 12 | Framework PHP backend |
| MySQL | Database |
| Blade | Template engine |
| Font Awesome 6 | Icon library |
| SweetAlert2 | Alert modern |
| JavaScript | Frontend interaktif |

---

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Web Server (Apache/Nginx/Laragon/XAMPP)
- Browser modern (Chrome, Firefox, Edge)
