# Aye Bouquet — UMKM Gift & Custom Order Website

Website katalog produk dan pemesanan buket/gift custom untuk UMKM **Aye Bouquet**. Pelanggan dapat browsing produk, custom order, dan checkout langsung via WhatsApp.

## Tech Stack

| Layer | Teknologi |
|---|---|
| Framework | CodeIgniter 4.6.x |
| Language | PHP 8.2+ |
| Database | MySQL (InnoDB) |
| Frontend | Tailwind CSS (CDN), Plus Jakarta Sans font, Material Symbols icons |
| Animasi | Animate.css, SweetAlert2 |
| Auth | Session-based (customer + admin terpisah) |

## Struktur Singkat

```
ci4_web_bucket_umkm/
├── app/
│   ├── Config/          # Routes, Database, Filters, dll
│   ├── Controllers/     # Frontend + Admin controllers
│   ├── Database/
│   │   ├── Migrations/  # Skema database (versioned)
│   │   └── Seeds/       # Data awal (admin, kategori, produk demo)
│   ├── Helpers/         # cart_helper, date_helper
│   ├── Models/          # Active Record models
│   └── Views/           # Layouts, partials, pages, admin views
├── public/
│   ├── assets/          # Logo, no-image.svg, hero image
│   └── uploads/         # Produk, kategori, galeri, testimoni (user-generated)
├── writable/            # Cache, logs, session, debugbar
├── .env                 # Konfigurasi environment (tidak ikut git)
├── .gitignore
└── env                  # Template .env (bawaan CI4)
```

## Syarat Environment

- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+
- Composer 2.x
- Apache mod_rewrite atau Nginx
- Ekstensi PHP: `intl`, `mbstring`, `mysqli`, `gd` (untuk upload gambar)

## Cara Install

```bash
# 1. Clone repositori
git clone <repo-url> ci4_web_bucket_umkm
cd ci4_web_bucket_umkm

# 2. Install dependensi Composer
composer install

# 3. Copy file environment
cp env .env
# atau copy manual dari file env → .env

# 4. Edit .env — sesuaikan database dan baseURL
```

## Cara Setting `.env`

Buka file `.env` dan sesuaikan:

```ini
# -------------------------------------------------------------------
# ENVIRONMENT
# -------------------------------------------------------------------
CI_ENVIRONMENT = development

# -------------------------------------------------------------------
# APP
# -------------------------------------------------------------------
app.baseURL = 'http://localhost/ci4_web_bucket_umkm/'
app.indexPage = ''

# -------------------------------------------------------------------
# DATABASE
# -------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = db_bucket_umkm
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

> **Catatan:** Jangan commit file `.env` ke git. File ini sudah masuk `.gitignore`.

## Cara Migrate dan Seed

```bash
# Buat database MySQL terlebih dahulu:
# CREATE DATABASE db_bucket_umkm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Jalankan migration (membuat tabel)
php spark migrate

# Jalankan seeder (data awal: admin, kategori, produk demo, pengaturan)
php spark db:seed InitialDataSeeder
```

## URL Frontend

| Halaman | URL |
|---|---|
| Beranda | `/` |
| Katalog Produk | `/katalog` |
| Detail Produk | `/produk/{slug}` |
| Custom Order | `/custom-order` |
| Testimoni | `/testimoni` |
| Tentang Kami | `/tentang` atau `/tentang-kami` |
| Galeri | `/galeri` |
| Kontak & FAQ | `/kontak` |
| Login | `/login` |
| Register | `/register` |
| Keranjang | `/keranjang` (harus login) |
| Checkout | `/checkout` (harus login) |

## URL Admin

| Halaman | URL |
|---|---|
| Login Admin | `/admin/login` |
| Dashboard | `/admin/` |
| Kelola Produk | `/admin/produk` |
| Kelola Kategori | `/admin/kategori` |
| Kelola Pesanan | `/admin/pesanan` |
| Kelola Galeri | `/admin/galeri` |
| Kelola FAQ | `/admin/faqs` |
| Kelola Testimoni | `/admin/testimonials` |
| Kelola Custom Options | `/admin/custom-options` |
| Kelola Kontak | `/admin/contact` |

## Akun Demo

Setelah menjalankan seeder, akun berikut tersedia untuk testing:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@ayebouquet.com` | `admin123` |
| Customer | `pelanggan@example.com` | `user12345` |

> Ganti password admin sebelum deploy ke production.

## Fitur Utama

- **Katalog produk** dengan filter kategori, ukuran, harga, warna, status
- **Detail produk** dengan galeri gambar, pilih varian (size), catatan custom
- **Keranjang belanja** session-based (login required)
- **Checkout** via WhatsApp — pesanan tersimpan di database, redirect ke WA
- **Custom Order** — form mandiri dengan pilihan size, warna, addon → kirim ke WA
- **Testimoni** — form submission dengan foto + approval admin
- **Galeri hasil produk** — portofolio pesanan yang sudah jadi
- **FAQ** — pertanyaan umum, dikelola via admin
- **Dark mode** — toggle tema gelap/terang
- **Admin panel** — CRUD produk, kategori, galeri, FAQ, testimoni, pesanan, pengaturan kontak
- **Export pesanan** — CSV + printable view
- **WhatsApp number** — dapat diubah via admin panel (settings), tidak hardcoded

## Catatan Deploy

1. **Environment**: Set `CI_ENVIRONMENT = production` di `.env`
2. **Base URL**: Sesuaikan `app.baseURL` dengan domain production
3. **Database**: Buat database production, update kredensial di `.env`
4. **Encryption key**: Ganti `encryption.key` di `.env` dengan key baru yang aman
5. **Upload folder**: Pastikan `public/uploads/` dan subdirektorinya writable oleh web server
6. **Writable folder**: Pastikan `writable/cache/`, `writable/logs/`, `writable/session/` writable
7. **Remove `.htaccess` issues**: Pastikan `mod_rewrite` aktif di Apache
8. **Remove demo accounts**: Hapus atau ganti password akun demo sebelum production
9. **WhatsApp number**: Atur nomor WhatsApp asli via Admin → Kelola Kontak
10. **Images**: Hapus gambar produk/kategori demo dan upload gambar asli
11. **SEO**: Update meta tags, deskripsi, dan Open Graph sesuai kebutuhan
