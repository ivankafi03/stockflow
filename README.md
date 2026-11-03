# StockFlow - Enterprise Inventory & Asset Tracking System

[![Laravel](https://img.shields.io/badge/Laravel-10.x-black?style=flat-square&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-black?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-black?style=flat-square&logo=php)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-black?style=flat-square)](https://opensource.org/licenses/MIT)

StockFlow adalah sistem informasi manajemen inventaris dan logistik pergudangan terintegrasi. Sistem ini dikembangkan untuk mengoptimalkan pencatatan mutasi barang, menjaga akurasi saldo persediaan, melakukan evaluasi valuasi aset, serta memberikan pengawasan ambang batas persediaan minimum secara terotomatisasi.

---

## Modul dan Fungsionalitas Utama

### 1. Executive Dashboard & Reporting
- Monitoring metrik operasional mencakup total ragam item, volume unit fisik, dan valuasi aset total berbasis harga perolehan.
- Notifikasi status persediaan kritis (*Low Stock Alert* dan *Stock Depleted*).
- Audit trail transaksi persediaan terkini secara real-time.

### 2. Manajemen Master Data Katalog
- Pengelolaan kode identifikasi unik (Stock Keeping Unit / SKU).
- Struktur kategorisasi berjenjang.
- Dokumentasi visual spesifikasi barang.
- Konfigurasi satuan pengukuran (Pieces, Box, Kilogram, Roll, dsb.).
- Parameterisasi harga perolehan dan nilai jual.

### 3. Kontrol Mutasi Persediaan (ACID Transactional)
- **Inbound Transaction:** Pencatatan penerimaan persediaan dan restock disertai dokumentasi Purchase Order / Surat Jalan.
- **Outbound Transaction:** Pengeluaran persediaan untuk kebutuhan operasional atau distribusi dengan validasi ketersediaan stok fisik guna mencegah anomali kuantitas negatif.
- Integritas data dikelola menggunakan Database Transactions.

### 4. Pelaporan dan Ekspor Data
- Penyaringan data inventaris berdasarkan kategori, status kondisi persediaan, dan parameter pencarian.
- Fitur ekspor seluruh data master persediaan ke format CSV/Excel terstandarisasi dengan kompatibilitas UTF-8 BOM.

### 5. Keamanan dan Autentikasi Pengguna
- Manajemen hak akses dan verifikasi profil berbasis otentikasi terenkripsi.

---

## Arsitektur Perangkat Lunak

- **Framework Backend:** Laravel 10 (PHP 8.1+)
- **Arsitektur Antarmuka:** Blade Component Architecture, Tailwind CSS, Alpine.js, Vite
- **Database Engine:** SQLite / MySQL Ready
- **Pola Desain:** Model-View-Controller (MVC), Eloquent ORM, Database Transactions

---

## Prosedur Instalasi Lingkungan Lokal

Berikut adalah prosedur konfigurasi sistem pada lingkungan pengujian lokal:

### 1. Kloning Repositori
```bash
git clone https://github.com/ivankafi03/stockflow.git
cd stockflow
```

### 2. Instalasi Dependensi
```bash
composer install
npm install
```

### 3. Konfigurasi Lingkungan (.env)
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Inisialisasi Database dan Data Pengujian
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### 5. Tautan Penyimpanan Berkas
```bash
php artisan storage:link
```

### 6. Kompilasi Aset dan Menjalankan Server
```bash
npm run build
php artisan serve
```

Sistem dapat diakses melalui browser pada alamat: `http://127.0.0.1:8000`

---

## Akun Otentikasi Pengujian

Untuk pengujian sistem, akun administratif bawaan yang tersedia:

| Atribut | Keterangan |
| :--- | :--- |
| **Endpoint Login** | `http://127.0.0.1:8000/login` |
| **Username / Email** | `admin@stockflow.test` |
| **Kata Sandi** | `password` |

---

## Skema Relasional Database

- **Categories to Items (One-to-Many):** Klasifikasi hierarkis setiap entitas barang.
- **Items to Stock Movements (One-to-Many):** Seluruh rekaman mutasi kuantitas terikat pada entitas barang secara spesifik.
- **Users to Stock Movements (One-to-Many):** Akuntabilitas pencatatan transaksi terasosiasi langsung dengan identitas personil yang bertugas.

---

## Lisensi
Projek ini dilisensikan di bawah ketentuan [MIT License](LICENSE).
