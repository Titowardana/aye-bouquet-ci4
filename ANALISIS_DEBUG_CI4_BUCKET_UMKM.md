# ANALISIS DEBUG CI4 BUCKET UMKM

## Ringkasan Perbaikan
Project CodeIgniter 4 telah diekstrak, diperiksa struktur route/controller/model/view/migration/seeder, lalu diedit langsung. Fokus perbaikan utama berada pada alur login pelanggan, keranjang, checkout, penyimpanan pesanan, template WhatsApp, admin kontak/settings, info pengiriman/cara pemesanan dari database, badge keranjang, serta catatan custom per item.

> Catatan pengecekan: `php spark` tidak dapat dijalankan di environment pemeriksaan ini karena ekstensi PHP `mbstring` tidak aktif (`mb_strpos()` tidak tersedia). Sebagai pengganti, seluruh file PHP di folder `app` sudah dicek menggunakan `php -l` dan tidak ditemukan syntax error.

## Masalah yang Ditemukan
1. Keranjang sudah memakai session, tetapi update qty belum benar-benar tersimpan ke server karena perubahan qty sebelumnya hanya dilakukan lewat JavaScript tampilan.
2. Catatan custom per item belum bisa diedit secara jelas dari halaman keranjang.
3. Badge keranjang perlu dipastikan menghitung total `qty`, bukan jumlah item array.
4. Checkout sudah menyimpan order, tetapi detail WhatsApp dan item order belum menyimpan/memuat SKU serta link produk.
5. Template WhatsApp detail produk masih terlalu sederhana.
6. Isi tab `Info Pengiriman` dan `Cara Pemesanan` di detail produk masih hardcoded di view.
7. Admin kontak/settings belum menyediakan field untuk mengatur info pengiriman, cara pemesanan, estimasi pengerjaan, catatan pre-order, info free item, dan footer text.
8. Default status order pada migration belum selaras dengan status yang dipakai admin (`baru`, `diproses`, `selesai`, `dibatalkan`).
9. Default role user pada migration lebih aman jika `user`, bukan `admin`.
10. Produk habis masih berpotensi masuk keranjang jika tidak dicegah di controller.

## File yang Diubah
- `app/Controllers/Cart.php`
- `app/Controllers/Checkout.php`
- `app/Controllers/Product.php`
- `app/Controllers/Admin/Contact.php`
- `app/Models/SettingModel.php`
- `app/Models/OrderItemModel.php`
- `app/Models/ProductVariantModel.php`
- `app/Views/pages/keranjang.php`
- `app/Views/pages/detail_produk.php`
- `app/Views/admin/contact/index.php`
- `app/Views/admin/order/detail.php`
- `app/Views/partials/footer.php`
- `app/Database/Migrations/2026-06-01-010001_CreateUsersTable.php`
- `app/Database/Migrations/2026-06-02-152839_CreateOrdersTable.php`
- `app/Database/Migrations/2026-06-02-152847_CreateOrderItemsTable.php`
- `app/Database/Migrations/2026-06-03-010000_AddSkuProductUrlToOrderItems.php`
- `app/Database/Seeds/InitialDataSeeder.php`
- `ANALISIS_DEBUG_CI4_BUCKET_UMKM.md`

## Route yang Dicek/Diperbaiki
Route keranjang dan checkout sudah berada di group filter `userAuth`:
- `GET /keranjang`
- `GET /keranjang/add` diarahkan ke katalog dengan pesan error rapi agar tidak 404 saat dibuka langsung.
- `POST /keranjang/add`
- `POST /keranjang/update`
- `POST /keranjang/remove`
- `POST /keranjang/clear`
- `GET /checkout`
- `POST /checkout/process`

Route typo `custem-order` tetap disediakan sebagai alias agar link lama tidak langsung rusak, sedangkan route benar `custom-order` tetap digunakan.

## Controller yang Diperbaiki
### `Cart.php`
- Menambahkan validasi `product_id`, `variant_id`, dan `qty`.
- Menolak produk dengan status `habis` agar tidak bisa dimasukkan ke keranjang.
- Memastikan tombol tambah keranjang memakai POST.
- Menyimpan data item cart lebih lengkap: produk, varian, SKU, kategori, status, catatan, link produk, harga, gambar, dan slug.
- Jika item sama ditambahkan lagi, `qty` bertambah.
- Update keranjang sekarang menyimpan `qty` dan `custom_notes` ke session, bukan hanya mengubah tampilan.

### `Checkout.php`
- Checkout akan redirect ke keranjang jika cart kosong.
- Pesanan disimpan ke tabel `orders` dan `order_items`.
- `order_items` sekarang menerima SKU dan link produk.
- Template WhatsApp checkout dibuat lebih lengkap: nama pemesan, penerima, nomor HP, metode pengiriman/pengambilan, alamat, tanggal/jam, produk, SKU, kategori, varian, status, qty, harga, subtotal, catatan custom, link produk, kartu ucapan, dan catatan tambahan.
- Redirect WhatsApp memakai `rawurlencode()` agar format pesan tidak rusak.

### `Product.php`
- Detail produk sekarang mengirim data settings/kontak ke view agar tab info pengiriman dan cara pemesanan bisa diambil dari database.

### `Admin/Contact.php`
- Admin dapat mengubah data kontak, footer, Google Maps, jam operasional, jam pickup, jam pengiriman.
- Ditambahkan field pengaturan produk: `delivery_info`, `order_guide`, `processing_estimate`, `preorder_note`, dan `free_item_info`.

## Model yang Diperbaiki
### `SettingModel.php`
- `getContactSettings()` sekarang mengembalikan field tambahan:
  - `footer_text`
  - `delivery_info`
  - `order_guide`
  - `processing_estimate`
  - `preorder_note`
  - `free_item_info`

### `OrderItemModel.php`
- Ditambahkan allowed fields:
  - `sku`
  - `product_url`

### `ProductVariantModel.php`
- `getByProduct()` sekarang hanya mengambil varian aktif (`is_active = 1`).

## View yang Diperbaiki
### `pages/keranjang.php`
- Halaman keranjang dibuat ulang agar user bisa:
  - mengubah qty,
  - mengurangi qty,
  - menambah qty,
  - menghapus item,
  - mengedit catatan custom per item,
  - mengosongkan keranjang.
- Setiap update dikirim ke server melalui form POST + CSRF.
- Ringkasan subtotal membaca data aktual dari session.

### `pages/detail_produk.php`
- Tombol tambah keranjang tetap memakai form POST.
- Produk dengan status `habis` tombol tambah keranjangnya disabled.
- Template WhatsApp detail produk sekarang lebih lengkap:
  - nama produk,
  - kategori,
  - SKU,
  - varian/ukuran,
  - harga estimasi,
  - jumlah,
  - status produk,
  - catatan custom,
  - link produk,
  - permintaan konfirmasi stok dan pembayaran.
- Tab `Info Pengiriman` dan `Cara Pemesanan` sekarang membaca dari settings/admin, bukan hardcoded.

### `admin/contact/index.php`
- Ditambahkan textarea/form untuk:
  - Footer text,
  - Info pengiriman,
  - Cara pemesanan,
  - Estimasi pengerjaan,
  - Catatan pre-order,
  - Info free item.

### `admin/order/detail.php`
- Detail pesanan admin sekarang menampilkan SKU dan link produk bila tersedia.

### `partials/footer.php`
- Footer text sekarang membaca dari settings admin.

## Migration/Seeder yang Ditambahkan atau Diubah
### Diubah
- `CreateUsersTable`
  - Kolom `phone` tersedia.
  - Role mendukung `user`, `admin`, `superadmin`.
  - Default role diubah ke `user` agar lebih aman.

- `CreateOrdersTable`
  - Default status diubah ke `baru` agar konsisten dengan admin order.

- `CreateOrderItemsTable`
  - Ditambahkan kolom `sku` dan `product_url` untuk fresh install.

### Ditambahkan
- `2026-06-03-010000_AddSkuProductUrlToOrderItems.php`
  - Migration tambahan untuk project/database yang sudah pernah migrate sebelumnya.
  - Menambah kolom `sku` dan `product_url` jika belum ada.

### Seeder
- `InitialDataSeeder` ditambah settings baru untuk footer, info pengiriman, cara pemesanan, estimasi pengerjaan, catatan pre-order, dan info free item.
- Akun demo tetap tersedia.

## Fitur yang Sudah Diperbaiki
- Register pelanggan masuk ke tabel `users` dengan role `user`.
- Login pelanggan tetap terpisah dari login admin.
- Login admin hanya menerima role `admin` dan `superadmin`.
- `/keranjang` dan `/checkout` wajib login.
- `/keranjang/add` GET tidak 404 dan diarahkan ke katalog.
- Tambah keranjang menggunakan POST.
- Qty dan catatan custom bisa diedit dari halaman keranjang.
- Badge keranjang membaca total qty dari session.
- Checkout menyimpan pesanan ke database.
- Pesanan tampil di admin pesanan.
- Admin bisa melihat detail pesanan dan mengubah status.
- WhatsApp checkout memakai template lengkap dan encoded.
- WhatsApp detail produk memakai template lengkap dan encoded.
- Info pengiriman dan cara pemesanan bisa diedit dari admin settings.
- Footer membaca data settings.
- Produk habis dicegah masuk keranjang.
- CSRF field tersedia di form POST yang diedit.

## Fitur yang Masih Perlu Pengembangan Lanjutan
1. Payment gateway belum dibuat sesuai batasan permintaan; pembayaran tetap manual/WhatsApp.
2. Relasi gambar berbeda per varian masih memakai mapping urutan gambar-varian. Untuk hasil lebih presisi, disarankan menambah kolom `image` atau `product_image_id` pada tabel `product_variants`.
3. Jika ingin order history pelanggan, perlu halaman riwayat pesanan user.
4. Jika ingin stok numerik, perlu menambah kolom stok per produk/varian.
5. `php spark` belum bisa diverifikasi di environment ini karena ekstensi PHP `mbstring` tidak aktif; aktifkan `mbstring` di PHP lokal/WAMP.

## Cara Menjalankan Project di Localhost
1. Ekstrak ZIP project ke folder kerja, misalnya `www/ci4_web_bucket_umkm` pada WAMPServer.
2. Masuk ke folder project:
   ```bash
   cd ci4_web_bucket_umkm
   ```
3. Install dependency:
   ```bash
   composer install
   ```
4. Copy/set `.env` dari file `env` jika diperlukan.
5. Atur `.env`:
   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = db_bucket_umkm
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```
6. Buat database MySQL:
   ```sql
   CREATE DATABASE db_bucket_umkm CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```
7. Jalankan migration:
   ```bash
   php spark migrate
   ```
8. Jalankan seeder:
   ```bash
   php spark db:seed InitialDataSeeder
   ```
9. Jalankan server:
   ```bash
   php spark serve
   ```
10. Buka:
   ```text
   http://localhost:8080
   ```

## Akun Login Demo
### Admin/Superadmin
- URL: `/admin/login`
- Email: `admin@bespokebloom.com`
- Password: `admin123`

### Pelanggan
- URL: `/login`
- Email: `pelanggan@example.com`
- Password: `user12345`

## Catatan Penting untuk WAMPServer
Jika muncul error `Call to undefined function mb_strpos()`, aktifkan ekstensi `mbstring`:
1. Buka menu WAMPServer.
2. Pilih PHP extensions.
3. Centang `mbstring`.
4. Restart all services.

Setelah itu jalankan kembali:
```bash
php spark migrate
php spark db:seed InitialDataSeeder
php spark serve
```
