# 📦 StockFlow — Smart Inventory & Asset Tracker

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

**StockFlow** adalah aplikasi web manajemen inventaris dan pelacakan aset operasional (*real-time inventory & stock audit trail*). Dirancang untuk mempermudah bisnis, pergudangan, maupun divisi operasional kantor dalam memonitor saldo persediaan barang, mencatat mutasi barang masuk/keluar, mendeteksi stok menipis secara otomatis (*low stock warning*), serta mengekspor data inventaris ke format CSV/Excel.

---

## ✨ Fitur Utama

- **📊 Comprehensive Executive Dashboard:**
  - Ringkasan metrik total jenis barang, kuantitas unit fisik di gudang, dan total valuasi nilai aset rupiah.
  - Kartu peringatan interaktif untuk barang dengan status **Stok Menipis** dan **Stok Habis (0)**.
  - Tabel aktivitas audit mutasi stok terkini secara real-time.

- **🏷️ Master Data Barang & Katalog:**
  - Penomoran kode SKU unik (*auto-suggestion* & custom).
  - Klasifikasi barang berdasarkan multi-kategori.
  - Upload & preview foto barang.
  - Multi-satuan fisik (*Pcs, Box, Roll, Pack, Kg, Unit, dll.*).
  - Pencatatan harga modal (beli) dan harga jual.

- **🔄 Sistem Mutasi Stok Transaksional (ACID Compliant):**
  - **Barang Masuk (+ In):** Pengadaan / Restock dari supplier dengan pencatatan nomor PO / Surat Jalan.
  - **Barang Keluar (- Out):** Pemakaian operasional atau penjualan dengan validasi stok otomatis (mencegah stok minus).
  - Setiap mutasi dibungkus dalam `DB::transaction()` untuk integritas data persediaan.

- **⚠️ Automated Low Stock Warning:**
  - Sistem otomatis memberi tanda peringatan kuning (*warning*) jika sisa stok $\le$ batas minimum (*min_stock*).
  - Tanda merah menyala (*danger*) jika stok habis total.

- **📁 Filter Cepat & Ekspor CSV:**
  - Filter barang berdasarkan kategori, status stok (Aman / Menipis / Habis), dan pencarian instan nama atau SKU.
  - Satu klik untuk download seluruh rekapitulasi data inventaris ke format CSV (kompatibel penuh dengan Microsoft Excel berkat UTF-8 BOM).

- **🔐 Autentikasi & Keamanan:**
  - Sistem login, registrasi, dan manajemen profil pengguna terenkripsi menggunakan Laravel Breeze.

---

## 🛠️ Tech Stack & Arsitektur

- **Backend:** Laravel 10 (PHP 8.1+)
- **Frontend / UI:** Blade Templates, Tailwind CSS, Alpine.js, Vite
- **Database:** SQLite (default zero-configuration, langsung jalan tanpa setup MySQL) / MySQL Ready
- **Pola Desain:** MVC (Model - View - Controller), Eloquent ORM, Database Transactions, Seeders & Factories

---

## 🚀 Panduan Instalasi Cepat (Local Setup)

Ikuti langkah-langkah mudah berikut untuk menjalankan projek ini di komputermu:

### 1. Clone Repositori
```bash
git clone https://github.com/USERNAME_KAMU/stockflow.git
cd stockflow
```

### 2. Install Dependensi PHP & Node.js
```bash
composer install
npm install
```

### 3. Setup Environment File
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database & Jalankan Seeder
```bash
# Inisialisasi database SQLite kosong (jika belum ada)
touch database/database.sqlite

# Migrasi tabel dan isi dengan data dummy simulasi lengkap
php artisan migrate:fresh --seed
```

### 5. Hubungkan Storage Symlink
```bash
php artisan storage:link
```

### 6. Compile Aset & Jalankan Server Lokal
```bash
# Compile aset CSS/JS
npm run build

# Jalankan server Laravel
php artisan serve
```

Buka browsermu di: **`http://127.0.0.1:8000`** 🎉

---

## 🔑 Akun Demo (Default Login)

Database seeder sudah menyediakan akun demo siap pakai:

| Field | Keterangan |
| :--- | :--- |
| **URL Login** | `http://127.0.0.1:8000/login` |
| **Email** | `admin@stockflow.test` |
| **Password** | `password` |

---

## 🗄️ Relasi Database (Schema Overview)

- **`categories`** (1) $\longleftrightarrow$ (M) **`items`**
  - Satu kategori memiliki banyak item barang.
- **`items`** (1) $\longleftrightarrow$ (M) **`stock_movements`**
  - Setiap mutasi stok (in/out) terhubung langsung ke item barang terkait.
- **`users`** (1) $\longleftrightarrow$ (M) **`stock_movements`**
  - Setiap pergerakan stok memiliki audit log yang mencatat siapa user/operator yang menginput transaksi.

---

## 📜 Lisensi
Projek ini dibuat di bawah lisensi [MIT License](LICENSE). Bebas digunakan dan dikembangkan untuk keperluan portofolio, pembelajaran, maupun referensi profesional.
