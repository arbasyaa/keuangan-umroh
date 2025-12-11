# Sistem Pencatatan Keuangan Umroh

Sistem pencatatan keuangan lokal untuk persiapan Umroh, dirancang khusus untuk wanita usia 40-50 tahun dengan desain minimalis dan profesional.

## Fitur

- ✅ Pencatatan transaksi debit/kredit
- ✅ Kategori transaksi (Paspor, Pembelian)
- ✅ Upload bukti transaksi (wajib)
- ✅ Running balance otomatis
- ✅ Export laporan PDF
- ✅ Desain responsif dengan Tailwind CSS
- ✅ Bahasa Indonesia

## Tech Stack

- **Laravel 10** - Framework PHP
- **MySQL** - Database
- **Tailwind CSS** - Styling (via CDN)
- **DomPDF** - PDF Export

## Instalasi

### 1. Clone/Extract Project

```bash
cd /home/arbasya/Projek\ Umroh
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=umroh_keuangan
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database

```bash
mysql -u root -p
CREATE DATABASE umroh_keuangan;
exit;
```

### 6. Jalankan Migrasi

```bash
php artisan migrate
```

### 7. Seed Data Kategori

```bash
php artisan db:seed --class=CategorySeeder
```

### 8. Setup Storage Link

```bash
php artisan storage:link
```

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

## Struktur Database

### Table: `categories`
- `id` - Primary Key
- `name` - Nama kategori (Paspor, Pembelian)
- `timestamps`

### Table: `transactions`
- `id` - Primary Key
- `date` - Tanggal transaksi
- `category_id` - Foreign Key ke categories
- `type` - Enum (debit/credit)
- `amount` - Jumlah transaksi (decimal 15,2)
- `description` - Catatan (nullable)
- `proof_image` - Path gambar bukti (required)
- `timestamps`

## Fitur UI/UX

### Desain untuk Target User (40-50 tahun)
- ✨ Font besar dan mudah dibaca
- ✨ Spacing yang luas
- ✨ Kontras tinggi (text-slate-800)
- ✨ Tombol besar dengan ikon jelas
- ✨ Warna teal yang elegan dan profesional
- ✨ Minimal distraksi, fokus pada data

### Fitur Khusus
- **Running Balance**: Total saldo berjalan otomatis di setiap baris
- **Color Coding**: 
  - Hijau untuk uang masuk (debit)
  - Merah untuk uang keluar (credit)
- **Thumbnail Bukti**: Preview gambar langsung di tabel
- **Form Intuitif**: Radio button besar untuk pilihan debit/credit
- **Validasi Ketat**: Bukti transaksi wajib diunggah

## Cara Penggunaan

### Tambah Transaksi
1. Klik tombol "Tambah Transaksi Baru"
2. Isi formulir:
   - Pilih tanggal
   - Pilih kategori
   - Pilih jenis (Masuk/Keluar)
   - Masukkan jumlah
   - Tambahkan catatan (opsional)
   - **Upload bukti transaksi (WAJIB)**
3. Klik "Simpan Transaksi"

### Lihat Laporan
- Tabel otomatis menampilkan semua transaksi
- Kolom "Total" menampilkan saldo berjalan
- Card "Saldo Akhir" di bawah tabel

### Export PDF
- Klik tombol "Download PDF"
- File akan terunduh otomatis dengan nama:
  `laporan-keuangan-umroh-YYYY-MM-DD.pdf`

### Hapus Transaksi
- Klik tombol hapus (ikon tempat sampah) di kolom aksi
- Konfirmasi penghapusan
- Gambar bukti otomatis terhapus dari storage

## Troubleshooting

### Error: Class 'Pdf' not found
```bash
composer require barryvdh/laravel-dompdf
```

### Error: Storage link not found
```bash
php artisan storage:link
```

### Error: Permission denied di storage
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Gambar tidak tampil
Pastikan symbolic link storage sudah dibuat:
```bash
php artisan storage:link
```

## File Structure

```
app/
├── Http/Controllers/
│   └── TransactionController.php
└── Models/
    ├── Category.php
    └── Transaction.php

database/
├── migrations/
│   ├── 2024_01_01_000001_create_categories_table.php
│   └── 2024_01_01_000002_create_transactions_table.php
└── seeders/
    └── CategorySeeder.php

resources/views/
├── layouts/
│   └── app.blade.php
└── transactions/
    ├── index.blade.php
    ├── create.blade.php
    └── pdf.blade.php

routes/
└── web.php

config/
└── dompdf.php
```

## Catatan Penting

- ✅ Semua transaksi HARUS memiliki bukti gambar
- ✅ Running balance dihitung secara real-time di controller
- ✅ Gambar disimpan di `storage/app/public/proofs`
- ✅ PDF menggunakan font Arial untuk kompatibilitas
- ✅ Sistem menggunakan format tanggal Indonesia (dd/mm/yyyy)
- ✅ Mata uang dalam Rupiah dengan format titik sebagai pemisah ribuan

## Support

Untuk pertanyaan atau bantuan, silakan hubungi developer.

---

**Dibuat dengan ❤️ untuk kemudahan pencatatan keuangan Umroh**
