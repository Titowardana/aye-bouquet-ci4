# AI Agent Brief — Implementasi Website UMKM Bucket/Gift Custom dengan CodeIgniter 4

## 1. Tujuan Proyek

Buat aplikasi web berbasis CodeIgniter 4 untuk UMKM produk bucket/gift/custom. Sistem ini bukan e-commerce penuh, melainkan website katalog dan pemesanan produk yang diarahkan ke WhatsApp.

Produk yang dikelola meliputi:
- Buket bunga
- Buket uang
- Buket snack/makanan
- Selempang
- Bloom box
- Single flower
- Custom gift

Fokus utama sistem:
- Menampilkan katalog produk
- Menampilkan detail produk
- Mendukung pilihan ukuran dan harga berbeda
- Mendukung keranjang sederhana
- Mendukung form checkout
- Menghasilkan pesan otomatis ke WhatsApp
- Menyediakan login/register
- Menyediakan admin untuk mengelola data produk

Sistem harus responsive dan mobile-friendly.

---

## 2. Batasan Penting

Jangan membuat fitur terlalu kompleks. Proyek ini adalah MVP.

### Fitur yang TIDAK perlu dibuat pada tahap awal:
- Payment gateway
- Stok otomatis
- Tracking pesanan penuh
- Live chat
- Dashboard laporan penjualan lengkap
- Aplikasi Android/iOS
- Sistem kasir
- Algoritma rekomendasi kompleks
- Rating/review real-time dari pelanggan

Pembayaran dan konfirmasi pesanan dilakukan melalui WhatsApp.

---

## 3. Aktor Sistem

### 3.1 Pelanggan/Pengunjung

Pelanggan dapat:
- Melihat beranda
- Melihat katalog produk
- Mencari produk
- Memfilter produk
- Melihat detail produk
- Memilih ukuran produk
- Register
- Login
- Menambahkan produk ke keranjang
- Mengubah/menghapus produk dari keranjang
- Mengisi checkout
- Mengisi custom order
- Checkout via WhatsApp
- Melihat galeri
- Melihat testimoni
- Melihat FAQ
- Melihat kontak dan lokasi

### 3.2 Admin UMKM

Admin dapat:
- Login admin
- Mengelola produk
- Mengelola kategori
- Mengelola ukuran produk
- Mengelola harga per ukuran
- Mengelola foto produk
- Mengelola status produk
- Mengelola galeri
- Mengelola testimoni
- Mengelola FAQ
- Mengelola profil UMKM
- Mengelola kontak dan lokasi

---

## 4. Prioritas Pengerjaan

### Prioritas 1 — Wajib Selesai

Kerjakan fitur ini terlebih dahulu:
1. Setup CodeIgniter 4
2. Koneksi database
3. Migration database utama
4. Layout utama pelanggan
5. Beranda
6. Katalog produk
7. Search produk
8. Filter kategori
9. Filter ukuran
10. Detail produk
11. Pilihan ukuran dan harga
12. Login/register
13. Keranjang sederhana
14. Form checkout
15. Checkout via WhatsApp
16. Custom order
17. Admin kelola kategori
18. Admin kelola produk
19. Upload foto produk
20. Responsive mobile

### Prioritas 2 — Setelah Fitur Inti Selesai

1. Tentang kami
2. Galeri
3. FAQ
4. Testimoni
5. Google Maps
6. Kontak dan media sosial
7. Status produk manual
8. Informasi metode pembayaran

### Prioritas 3 — Bonus

1. Wishlist
2. Dark/light mode
3. Rating visual
4. Rekomendasi produk serupa berdasarkan kategori

---

## 5. Struktur Route yang Harus Dibuat

### 5.1 Route Pelanggan

```php
$routes->get('/', 'Home::index');
$routes->get('/katalog', 'Product::index');
$routes->get('/produk/(:segment)', 'Product::detail/$1');

$routes->get('/cart', 'Cart::index');
$routes->post('/cart/add', 'Cart::add');
$routes->post('/cart/update', 'Cart::update');
$routes->post('/cart/delete/(:num)', 'Cart::delete/$1');

$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout/process', 'Checkout::process');

$routes->get('/custom-order', 'CustomOrder::index');
$routes->post('/custom-order/send', 'CustomOrder::send');

$routes->get('/tentang', 'Page::about');
$routes->get('/galeri', 'Gallery::index');
$routes->get('/faq', 'Faq::index');
$routes->get('/kontak', 'Page::contact');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');
```

### 5.2 Route Admin

```php
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    $routes->get('kategori', 'Admin\CategoryController::index');
    $routes->get('kategori/create', 'Admin\CategoryController::create');
    $routes->post('kategori/store', 'Admin\CategoryController::store');
    $routes->get('kategori/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('kategori/update/(:num)', 'Admin\CategoryController::update/$1');
    $routes->post('kategori/delete/(:num)', 'Admin\CategoryController::delete/$1');

    $routes->get('produk', 'Admin\ProductController::index');
    $routes->get('produk/create', 'Admin\ProductController::create');
    $routes->post('produk/store', 'Admin\ProductController::store');
    $routes->get('produk/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\ProductController::update/$1');
    $routes->post('produk/delete/(:num)', 'Admin\ProductController::delete/$1');
});
```

---

## 6. Struktur Folder yang Disarankan

```text
app/
├── Controllers/
│   ├── Home.php
│   ├── Product.php
│   ├── Cart.php
│   ├── Checkout.php
│   ├── CustomOrder.php
│   ├── Auth.php
│   ├── Gallery.php
│   ├── Faq.php
│   ├── Page.php
│   └── Admin/
│       ├── Dashboard.php
│       ├── ProductController.php
│       ├── CategoryController.php
│       ├── GalleryController.php
│       ├── TestimonialController.php
│       └── FaqController.php
│
├── Models/
│   ├── UserModel.php
│   ├── CategoryModel.php
│   ├── ProductModel.php
│   ├── ProductVariantModel.php
│   ├── CartModel.php
│   ├── GalleryModel.php
│   ├── TestimonialModel.php
│   └── FaqModel.php
│
├── Views/
│   ├── layouts/
│   │   ├── main.php
│   │   └── admin.php
│   ├── partials/
│   │   ├── navbar.php
│   │   ├── footer.php
│   │   └── product_card.php
│   ├── pages/
│   │   ├── home.php
│   │   ├── katalog.php
│   │   ├── detail_produk.php
│   │   ├── cart.php
│   │   ├── checkout.php
│   │   ├── custom_order.php
│   │   ├── about.php
│   │   ├── contact.php
│   │   └── faq.php
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   └── admin/
│       ├── dashboard.php
│       ├── produk/
│       ├── kategori/
│       ├── galeri/
│       ├── testimoni/
│       └── faq/
```

---

## 7. Database yang Harus Dibuat

Gunakan migration CodeIgniter 4.

### 7.1 Tabel `users`

```text
id
nama
no_hp
email
password
role            // customer atau admin
created_at
updated_at
```

### 7.2 Tabel `categories`

```text
id
nama_kategori
slug
created_at
updated_at
```

### 7.3 Tabel `products`

```text
id
category_id
nama_produk
slug
deskripsi
foto
warna
tema
status          // Ready, Pre-order, Habis
harga_mulai
created_at
updated_at
```

### 7.4 Tabel `product_variants`

```text
id
product_id
ukuran          // S, M, L, XL, XXL, Jumbo
harga
keterangan_harga
created_at
updated_at
```

### 7.5 Tabel `carts`

```text
id
user_id
product_id
variant_id
jumlah
tambahan
catatan_custom
created_at
updated_at
```

### 7.6 Tabel `galleries`

```text
id
judul
kategori
foto
created_at
updated_at
```

### 7.7 Tabel `testimonials`

```text
id
nama
isi_testimoni
rating
created_at
updated_at
```

### 7.8 Tabel `faqs`

```text
id
pertanyaan
jawaban
created_at
updated_at
```

---

## 8. Perintah Awal CodeIgniter 4

Jika project belum ada:

```bash
composer create-project codeigniter4/appstarter web-bucket
cd web-bucket
php spark serve
```

Buat migration:

```bash
php spark make:migration CreateUsersTable
php spark make:migration CreateCategoriesTable
php spark make:migration CreateProductsTable
php spark make:migration CreateProductVariantsTable
php spark make:migration CreateCartsTable
php spark make:migration CreateGalleriesTable
php spark make:migration CreateTestimonialsTable
php spark make:migration CreateFaqsTable
```

Buat model:

```bash
php spark make:model UserModel
php spark make:model CategoryModel
php spark make:model ProductModel
php spark make:model ProductVariantModel
php spark make:model CartModel
php spark make:model GalleryModel
php spark make:model TestimonialModel
php spark make:model FaqModel
```

Buat controller:

```bash
php spark make:controller Home
php spark make:controller Product
php spark make:controller Cart
php spark make:controller Checkout
php spark make:controller CustomOrder
php spark make:controller Auth
php spark make:controller Gallery
php spark make:controller Faq
php spark make:controller Page
php spark make:controller Admin/Dashboard
php spark make:controller Admin/ProductController
php spark make:controller Admin/CategoryController
```

---

## 9. Aturan Login

Gunakan konsep:

```text
Guest Mode + Login Saat Ingin Memesan
```

Artinya:
- Pengunjung boleh melihat beranda, katalog, detail produk, galeri, FAQ, dan kontak tanpa login.
- Login baru diwajibkan saat:
  - Tambah ke keranjang
  - Membuka keranjang
  - Checkout
  - Menggunakan fitur wishlist jika dibuat nanti

Role:
- `customer`
- `admin`

Admin tidak boleh masuk ke halaman admin jika role bukan `admin`.

---

## 10. Alur Checkout WhatsApp

Saat pelanggan klik checkout, sistem harus membuat pesan otomatis ke WhatsApp UMKM.

Format pesan:

```text
Halo kak, saya ingin melakukan pemesanan.

Nama Pemesan:
Nama Penerima:
Nomor HP:
Produk:
Ukuran:
Jumlah:
Warna Dominan:
Tema Acara:
Tambahan:
Isi Kartu Ucapan:
Tanggal Dibutuhkan:
Jam:
Metode Pengambilan:
Alamat:
Catatan Tambahan:

Mohon dikonfirmasi ya kak.
```

Contoh implementasi PHP:

```php
$pesan = "Halo kak, saya ingin melakukan pemesanan.%0A%0A";
$pesan .= "Nama Pemesan: " . $nama_pemesan . "%0A";
$pesan .= "Nama Penerima: " . $nama_penerima . "%0A";
$pesan .= "Nomor HP: " . $nomor_hp . "%0A";
$pesan .= "Produk: " . $produk . "%0A";
$pesan .= "Ukuran: " . $ukuran . "%0A";
$pesan .= "Jumlah: " . $jumlah . "%0A";
$pesan .= "Warna Dominan: " . $warna . "%0A";
$pesan .= "Tema Acara: " . $tema . "%0A";
$pesan .= "Tambahan: " . $tambahan . "%0A";
$pesan .= "Isi Kartu Ucapan: " . $kartu_ucapan . "%0A";
$pesan .= "Tanggal Dibutuhkan: " . $tanggal . "%0A";
$pesan .= "Jam: " . $jam . "%0A";
$pesan .= "Metode Pengambilan: " . $metode . "%0A";
$pesan .= "Alamat: " . $alamat . "%0A";
$pesan .= "Catatan Tambahan: " . $catatan . "%0A%0A";
$pesan .= "Mohon dikonfirmasi ya kak.";

$nomorWa = "628xxxxxxxxxx";
return redirect()->to("https://wa.me/" . $nomorWa . "?text=" . $pesan);
```

Catatan:
- Ganti `628xxxxxxxxxx` dengan nomor WhatsApp UMKM.
- Pastikan pesan menggunakan `urlencode()` atau format `%0A` agar baris baru terbaca di WhatsApp.

---

## 11. Filter Produk yang Harus Ada

Minimal:
- Search nama produk
- Filter kategori
- Filter harga
- Filter ukuran
- Filter warna
- Filter status produk

Status produk:
- Ready
- Pre-order
- Habis

Tampilan tombol berdasarkan status:
- Ready: tombol “Tambah ke Keranjang”
- Pre-order: tombol “Konsultasi / Pesan via WhatsApp”
- Habis: tombol “Tanya Ketersediaan via WhatsApp”

---

## 12. Data Seeder Awal

Buat data kategori:
- Buket Bunga
- Buket Uang
- Buket Snack / Makanan
- Selempang
- Bloom Box
- Single Flower
- Custom Gift

Buat minimal 6–10 produk dummy agar katalog terlihat penuh.

Contoh produk:
- Buket Bunga Pink Custom
- Buket Wisuda Mawar
- Buket Uang Premium
- Buket Snack Ulang Tahun
- Selempang Bunga Wisuda
- Bloom Box Anggrek
- Single Flower Rose
- Custom Gift Box

---

## 13. Aturan UI

Gunakan desain dari Google Stitch sebagai acuan utama.

Jika desain belum lengkap, gunakan gaya berikut:
- Warna utama: soft pink / pastel
- Tampilan modern, bersih, dan feminim
- Card produk rapi
- Tombol jelas
- Navbar sederhana
- Footer berisi kontak, WhatsApp, Instagram, alamat, dan jam operasional
- Responsif di mobile

Halaman wajib mobile-friendly:
- Beranda
- Katalog
- Detail produk
- Keranjang
- Checkout
- Login/register
- Admin produk

---

## 14. Halaman yang Harus Dibuat

### Pelanggan
- Beranda
- Katalog
- Detail Produk
- Keranjang
- Checkout
- Custom Order
- Tentang Kami
- Galeri
- FAQ
- Kontak
- Login
- Register

### Admin
- Dashboard
- Kelola Produk
- Tambah Produk
- Edit Produk
- Kelola Kategori
- Kelola Galeri
- Kelola Testimoni
- Kelola FAQ
- Kelola Kontak

---

## 15. Checklist Implementasi

Gunakan checklist ini agar tidak ada fitur yang terlewat.

### Setup
- [ ] Project CI4 berjalan
- [ ] `.env` aktif
- [ ] Database terkoneksi
- [ ] Base URL sesuai
- [ ] Folder upload produk tersedia
- [ ] Migration berhasil
- [ ] Seeder berhasil

### Auth
- [ ] Register customer
- [ ] Login customer
- [ ] Login admin
- [ ] Logout
- [ ] Session user
- [ ] Filter admin
- [ ] Proteksi halaman cart dan checkout

### Produk
- [ ] Kategori produk tampil
- [ ] Produk tampil di katalog
- [ ] Detail produk tampil
- [ ] Varian ukuran tampil
- [ ] Harga per ukuran tampil
- [ ] Status produk tampil
- [ ] Upload foto produk
- [ ] Edit produk
- [ ] Hapus produk

### Katalog
- [ ] Search produk
- [ ] Filter kategori
- [ ] Filter harga
- [ ] Filter ukuran
- [ ] Filter warna
- [ ] Filter status
- [ ] Produk tampil responsive

### Keranjang
- [ ] Tambah produk ke keranjang
- [ ] Pilih ukuran
- [ ] Tambah catatan custom
- [ ] Ubah jumlah
- [ ] Hapus item
- [ ] Total estimasi tampil

### Checkout
- [ ] Form checkout tampil
- [ ] Data pemesan lengkap
- [ ] Data produk dari keranjang terbaca
- [ ] Pesan WhatsApp terbentuk otomatis
- [ ] Redirect ke WhatsApp berhasil

### Custom Order
- [ ] Form custom order tampil
- [ ] Jenis produk tersedia
- [ ] Ukuran tersedia
- [ ] Budget tersedia
- [ ] Warna/tema/catatan tersedia
- [ ] Redirect ke WhatsApp berhasil

### Halaman Pendukung
- [ ] Tentang kami
- [ ] Galeri
- [ ] FAQ
- [ ] Testimoni
- [ ] Kontak
- [ ] Google Maps
- [ ] Footer

### Testing
- [ ] Cek desktop
- [ ] Cek mobile
- [ ] Cek login customer
- [ ] Cek login admin
- [ ] Cek tambah produk
- [ ] Cek tambah keranjang
- [ ] Cek checkout WhatsApp
- [ ] Cek upload foto
- [ ] Cek validasi form
- [ ] Cek tombol status produk

---

## 16. Larangan untuk AI Agent

Agar pengerjaan tidak melebar, jangan lakukan hal berikut sebelum fitur utama selesai:

- Jangan membuat payment gateway
- Jangan membuat tracking pesanan kompleks
- Jangan membuat dashboard grafik penjualan
- Jangan membuat sistem stok otomatis
- Jangan membuat chat real-time
- Jangan membuat aplikasi mobile
- Jangan membuat fitur review real-time
- Jangan mengubah framework dari CI4 ke Laravel/React/Vue kecuali diminta
- Jangan menghapus desain utama dari Google Stitch
- Jangan mengubah konsep checkout WhatsApp menjadi checkout pembayaran online
- Jangan membuat struktur database terlalu rumit

---

## 17. Cara Kerja yang Diharapkan dari AI Agent

AI agent harus bekerja bertahap:

1. Baca struktur project CI4 yang ada.
2. Jangan langsung mengubah semua file.
3. Periksa apakah project sudah berjalan.
4. Periksa `.env`, database, route, controller, model, dan view.
5. Buat atau perbaiki satu modul dalam satu waktu.
6. Setelah membuat modul, jelaskan file apa saja yang diubah.
7. Jalankan pengecekan error dasar.
8. Jangan menghapus file penting tanpa konfirmasi.
9. Jangan mengganti total struktur project jika tidak perlu.
10. Prioritaskan fitur MVP.

Urutan pengerjaan wajib:
1. Setup database dan migration
2. Model
3. Route
4. Controller
5. View pelanggan
6. Auth
7. Cart
8. Checkout WhatsApp
9. Admin produk
10. Halaman pendukung
11. Responsive testing

---

## 18. Output yang Diharapkan

AI agent harus menghasilkan:
- File migration
- File model
- File controller
- File view
- File route
- File filter auth/admin
- Seeder data awal
- Fitur checkout WhatsApp
- Admin kelola produk
- Tampilan responsive
- Dokumentasi perubahan

---

## 19. Catatan Penting

Nomor WhatsApp UMKM harus mudah diganti, sebaiknya disimpan di file konfigurasi atau database kontak.

Contoh:
```php
$nomorWa = '628xxxxxxxxxx';
```

Jangan hardcode terlalu banyak data di view. Data produk, kategori, varian, galeri, FAQ, dan testimoni sebaiknya berasal dari database.

Gunakan validasi form untuk:
- Register
- Login
- Tambah produk
- Edit produk
- Checkout
- Custom order

Gunakan `esc()` saat menampilkan data agar lebih aman.

Contoh:
```php
<?= esc($product['nama_produk']) ?>
```

---

## 20. Ringkasan Final

Website yang dibuat adalah sistem katalog dan pemesanan produk bucket/gift/custom UMKM berbasis CodeIgniter 4. Sistem memiliki dua aktor utama, yaitu pelanggan dan admin. Pelanggan dapat melihat produk, memilih ukuran, menambahkan ke keranjang, checkout, dan diarahkan ke WhatsApp. Admin dapat mengelola produk, kategori, ukuran, harga, status, galeri, testimoni, FAQ, dan kontak.

Prioritas utama adalah membuat sistem berjalan sesuai MVP, bukan membuat e-commerce kompleks.
