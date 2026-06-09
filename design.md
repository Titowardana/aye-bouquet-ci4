# design.md — Revisi Berdasarkan Desain Google Stitch

## 1. Status Desain

Dokumen ini adalah revisi `design.md` berdasarkan screenshot UI/UX Google Stitch yang sudah dibuat. Desain ini belum final 100% karena masih perlu divalidasi ke pihak UMKM, tetapi sudah sangat layak dijadikan acuan awal implementasi ke CodeIgniter 4.

Konsep utama desain:

```text
Soft, clean, modern, elegant, feminim, hangat, dan mudah digunakan.
```

Website ini adalah katalog dan pemesanan produk gift/custom melalui WhatsApp, bukan e-commerce penuh.

---

## 2. Catatan Utama dari Screenshot

Dari desain yang diberikan, terdapat dua halaman utama:

1. Homepage / Beranda
2. Catalog / Katalog Produk

Secara visual desain sudah kuat karena memiliki:
- Navbar bersih
- Hero section soft dengan background buket
- Warna mauve/pink/cream yang konsisten
- Kategori produk berbentuk card
- Produk populer
- Testimonial pelanggan
- Footer sederhana
- Katalog dengan sidebar filter
- Search bar
- Sort dropdown
- Card produk
- Badge status produk
- Pagination

Desain ini sudah cocok untuk website UMKM gift/custom.

---

## 3. Catatan Perbaikan Sebelum Final

Beberapa hal yang perlu diperbaiki sebelum desain dikunci:

### 3.1 Nama Brand Belum Konsisten

Pada homepage tertulis:

```text
Bespoke Bloom & Gift
```

Pada katalog tertulis:

```text
Gift Custom UMKM
```

Solusi:
- Gunakan satu nama brand final.
- Jangan hardcode nama brand di banyak file.
- Simpan nama brand di layout, file config, atau tabel setting agar mudah diganti.

### 3.2 Bahasa Menu Perlu Konsisten

Menu saat ini menggunakan bahasa Inggris:

```text
Home, Catalog, Testimonials, About Us, Contact
```

Jika target pelanggan lokal Indonesia, disarankan menjadi:

```text
Beranda, Katalog, Testimoni, Tentang Kami, Kontak
```

Pilih salah satu bahasa dan gunakan konsisten di semua halaman.

### 3.3 Menu Custom Order Belum Terlihat

Karena fitur custom order adalah fitur penting, sebaiknya ditampilkan di navbar atau tombol utama.

Pilihan:
- Tambahkan menu `Custom Order`
- Atau jadikan tombol CTA di hero dan katalog

### 3.4 Kategori Single Flower Belum Tampil

Jika Single Flower tetap masuk scope, tambahkan kategori:

```text
Single Flower
```

Jika tidak dijual oleh UMKM, boleh dihapus dari rancangan database dan tampilan.

### 3.5 Placeholder Produk di Katalog

Pada katalog, gambar produk masih placeholder. Untuk showcase atau pitching, sebaiknya gunakan:
- Foto produk asli UMKM
- Atau placeholder yang sesuai tema buket/gift

Jangan gunakan placeholder default ungu saat presentasi final.

---

## 4. Palet Warna Final dari Desain

Gunakan warna berikut sebagai acuan implementasi CSS:

```text
Primary Mauve/Burgundy : #7B4B61
Dark Mauve             : #6A3F53
Soft Pink              : #F7DCE8
Light Pink             : #FBEAF1
Cream Background       : #FAF7F5
Soft Beige             : #E8E3DE
White                  : #FFFFFF
Text Dark              : #1F1F1F
Text Muted             : #6F6F6F
Border Soft            : #E6D6DC
```

Warna status produk:

```text
Ready Background       : #C8F7DC
Ready Text             : #2E7D4F

Pre-order Background   : #FFD9A8
Pre-order Text         : #8A5A13

Habis Background       : #ECE9EF
Habis Text             : #555555
```

Aturan:
- Background utama gunakan cream atau putih.
- Warna utama untuk heading, tombol, active menu, dan pagination adalah mauve/burgundy.
- Pink muda digunakan untuk icon kategori dan aksen lembut.
- Jangan menambah warna mencolok di luar tema.

---

## 5. Typography

Gunakan font utama:

```text
Poppins
```

Alternatif:
```text
Inter
Nunito Sans
```

Rekomendasi CSS:

```css
body {
  font-family: 'Poppins', sans-serif;
}
```

Ukuran font acuan:

```text
Navbar brand       : 20px - 24px
Navbar menu        : 13px - 15px
Hero title         : 40px - 52px desktop, 28px - 34px mobile
Section title      : 28px - 34px desktop, 22px - 26px mobile
Catalog title      : 48px - 60px desktop, 32px - 40px mobile
Product card title : 16px - 20px
Body text          : 14px - 16px
Small text         : 11px - 13px
Button text        : 13px - 15px
```

---

## 6. Navbar

Navbar mengikuti desain Google Stitch.

Isi navbar:
- Nama brand di kiri
- Menu di tengah
- Icon cart dan akun di kanan

Menu yang disarankan:

```text
Beranda
Katalog
Custom Order
Testimoni
Tentang Kami
Kontak
```

Aturan desain:
- Background putih.
- Border bawah halus.
- Menu aktif diberi underline warna mauve.
- Icon cart dan user menggunakan warna mauve.
- Di mobile, navbar berubah menjadi hamburger.

---

## 7. Homepage / Beranda

Struktur homepage dari desain sudah baik.

Urutan section:
1. Navbar
2. Hero section
3. Kategori pilihan
4. Produk terpopuler
5. Testimonial pelanggan
6. Footer

Bagian ini dapat langsung dijadikan acuan coding.

---

## 8. Hero Section

Hero section memiliki background gambar buket dengan overlay soft pink/cream.

Komponen wajib:
- Badge kecil:
  ```text
  Momen Spesial, Kado Spesial
  ```
- Judul:
  ```text
  Pesan Buket dan Gift Custom Sesuai Keinginanmu
  ```
- Deskripsi singkat
- Tombol utama:
  ```text
  Belanja Sekarang
  ```
- Tombol kedua:
  ```text
  Buat Custom Order
  ```

Aturan:
- Teks berada di tengah.
- Background gambar harus soft agar teks terbaca.
- Tombol utama menggunakan warna mauve.
- Tombol kedua outline.
- Mobile harus tetap rapi dan tidak terlalu tinggi.

---

## 9. Kategori Pilihan

Kategori dari desain:
- Buket Bunga
- Buket Uang
- Buket Snack
- Selempang
- Bloom Box
- Custom Gift

Tambahkan jika diperlukan:
- Single Flower

Aturan:
- Card kategori background putih.
- Icon berada dalam lingkaran pink muda.
- Card memiliki rounded corner dan shadow halus.
- Kategori harus bisa diklik menuju katalog berdasarkan kategori.

Layout:
```text
Desktop : 6 card per baris jika cukup
Tablet  : 3 card per baris
Mobile  : 2 card per baris atau horizontal scroll
```

---

## 10. Produk Terpopuler

Desain menampilkan satu produk utama besar dan satu produk kecil.

Untuk implementasi awal, boleh gunakan:
- 1 produk unggulan besar
- 2 sampai 4 produk populer kecil

Isi card:
- Foto produk
- Kategori
- Nama produk
- Ukuran tersedia
- Harga / mulai dari
- Status produk
- Tombol detail atau icon keranjang

Aturan:
- Produk custom sebaiknya memakai teks `Mulai dari`.
- Status produk harus konsisten: `Ready`, `Pre-order`, `Habis`.
- Foto produk harus tajam dan tidak gepeng.

---

## 11. Testimonial

Desain testimonial sudah cocok.

Komponen:
- Rating bintang
- Isi testimoni
- Nama pelanggan
- Label pelanggan
- Avatar inisial

Aturan:
- Gunakan 3 testimonial di homepage.
- Card putih dengan shadow halus.
- Rating bintang menggunakan warna mauve.

---

## 12. Footer

Footer memakai background beige/abu-cream.

Isi footer:
- Nama brand
- Deskripsi singkat
- Icon media sosial
- Tautan cepat
- Kontak
- Alamat
- Nomor WhatsApp
- Copyright

Catatan:
- Footer homepage dan katalog harus konsisten.
- Gunakan bahasa yang sama di seluruh footer.
- Jangan membuat footer terlalu tinggi di mobile.

---

## 13. Halaman Katalog Produk

Desain katalog sudah sangat baik dan menjadi acuan utama.

Layout desktop:
```text
Kiri  : Sidebar filter
Kanan : Judul katalog, search, sort, grid produk, pagination
```

Layout mobile:
```text
Atas  : Judul katalog
Atas  : Search
Atas  : Tombol Filter
Bawah : Grid produk
```

Pada mobile, sidebar filter harus menjadi:
- Collapse
- Offcanvas
- Atau modal filter

Jangan tampilkan sidebar tetap di layar kecil.

---

## 14. Sidebar Filter

Filter yang wajib ada:
- Kategori
- Ukuran
- Rentang harga
- Warna
- Status

Kategori:
```text
Semua Produk
Buket Bunga
Buket Uang
Buket Snack
Selempang
Bloom Box
Custom Gift
Single Flower jika diperlukan
```

Ukuran:
```text
S
M
L
XL
XXL
Jumbo
```

Rentang harga:
```text
di bawah Rp50.000
Rp50.000 - Rp100.000
Rp100.000 - Rp200.000
Rp200.000 - Rp500.000
di atas Rp500.000
```

Warna:
- Pink
- Merah
- Putih
- Biru
- Ungu

Status:
```text
Ready
Pre-order
Habis
```

---

## 15. Search dan Sort

Search bar:
```text
Cari produk...
```

Aturan:
- Rounded besar.
- Icon search di kiri.
- Border soft mauve/pink.
- Mudah digunakan di mobile.

Sort:
```text
Featured
Terbaru
Harga Terendah
Harga Tertinggi
Nama A-Z
```

Jika menggunakan bahasa Indonesia:
```text
Urutkan
```

---

## 16. Card Produk Katalog

Isi card produk:
- Foto produk
- Badge status di pojok kanan atas
- Kategori
- Nama produk
- Ukuran tersedia
- Harga
- Tombol `Lihat Detail`

Aturan visual:
- Card putih.
- Border-radius 16px sampai 20px.
- Shadow lembut.
- Foto menggunakan object-fit cover.
- Badge status berada di atas gambar.
- Tombol detail berbentuk outline pill.
- Harga menggunakan warna mauve dan font tebal.

---

## 17. Pagination

Pagination mengikuti desain:
- Tombol angka rounded.
- Halaman aktif berwarna mauve.
- Previous dan next memakai icon panah.
- Mobile tetap sederhana.

---

## 18. Halaman Detail Produk

Walaupun belum ada screenshot, halaman detail harus mengikuti style katalog.

Layout desktop:
```text
Kiri  : Foto produk besar
Kanan : Informasi produk dan pilihan order
```

Komponen:
- Foto produk
- Nama produk
- Kategori
- Harga mulai dari
- Status
- Deskripsi
- Pilihan ukuran
- Tabel harga ukuran
- Tambahan aksesoris
- Catatan custom
- Tombol Tambah ke Keranjang
- Tombol Konsultasi via WhatsApp
- Produk serupa

---

## 19. Keranjang

Keranjang menggunakan gaya card putih.

Komponen:
- Foto produk
- Nama produk
- Ukuran
- Jumlah
- Harga estimasi
- Tambahan
- Catatan custom
- Tombol hapus
- Total estimasi
- Tombol lanjut checkout

Tambahkan catatan:
```text
Total hanya estimasi. Harga akhir dikonfirmasi melalui WhatsApp.
```

---

## 20. Checkout

Checkout harus mudah diisi di HP.

Komponen:
- Nama pemesan
- Nama penerima
- Nomor HP
- Tanggal dibutuhkan
- Jam
- Metode pengambilan
- Alamat
- Warna dominan
- Tema acara
- Tambahan aksesoris
- Isi kartu ucapan
- Catatan tambahan
- Ringkasan produk
- Tombol Checkout via WhatsApp

Aturan:
- Form dalam card putih.
- Input rounded.
- Tombol utama jelas.
- Ringkasan pesanan tampil sebelum checkout.

---

## 21. Custom Order

Custom order perlu ditonjolkan.

Komponen:
- Jenis produk
- Ukuran
- Budget
- Warna dominan
- Tema acara
- Jenis bunga/bahan
- Tambahan lampu
- Kartu ucapan
- Isi kartu ucapan
- Tanggal dibutuhkan
- Nama pemesan
- Nomor HP
- Catatan khusus
- Tombol Kirim ke WhatsApp

Tambahkan info:
```text
Jika memiliki referensi gambar, pelanggan dapat mengirimkannya melalui WhatsApp setelah form dikirim.
```

---

## 22. Admin

Admin tidak harus terlalu mewah, tetapi harus rapi.

Layout desktop:
```text
Sidebar kiri
Konten kanan
```

Isi dashboard:
- Jumlah produk
- Jumlah kategori
- Jumlah galeri
- Jumlah testimoni
- Shortcut tambah produk
- Shortcut kelola kategori

Admin produk:
- Tabel produk
- Search
- Filter kategori/status
- Tombol tambah produk
- Tombol edit
- Tombol hapus
- Preview foto

Kolom tabel:
```text
Foto
Nama Produk
Kategori
Harga Mulai
Status
Aksi
```

---

## 23. Responsive Design

Breakpoint:
```text
Mobile  : < 576px
Tablet  : 576px - 991px
Desktop : >= 992px
```

Aturan mobile:
- Navbar hamburger.
- Hero satu kolom.
- Kategori 2 kolom atau horizontal scroll.
- Produk 1 kolom.
- Filter katalog menjadi offcanvas/collapse.
- Form full width.
- Footer satu kolom.
- Tabel admin scroll horizontal.

---

## 24. Class CSS yang Disarankan

Gunakan class reusable:

```text
.btn-primary-custom
.btn-outline-custom
.badge-ready
.badge-preorder
.badge-habis
.product-card
.category-card
.section-title
.soft-card
.filter-sidebar
.form-control-custom
```

Hindari terlalu banyak inline style.

---

## 25. Struktur Asset

Gunakan struktur:

```text
public/
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── admin.css
│   ├── js/
│   │   └── main.js
│   └── images/
│       ├── logo.png
│       ├── hero-bouquet.jpg
│       └── placeholder-product.png
└── uploads/
    ├── products/
    └── gallery/
```

---

## 26. Validasi ke Pihak UMKM

Sebelum desain final, tanyakan:
1. Nama brand final
2. Warna utama yang disukai
3. Produk utama yang ingin ditonjolkan
4. Kategori produk yang benar-benar dijual
5. Nomor WhatsApp
6. Alamat dan Google Maps
7. Jam operasional
8. Bahasa website: Indonesia atau English
9. Harga pasti atau harga mulai dari
10. Ketersediaan foto produk asli

---

## 27. Larangan Desain

Jangan:
- Mengubah desain menjadi gelap
- Menggunakan warna neon
- Menghilangkan filter katalog
- Menghilangkan tombol WhatsApp
- Mencampur nama brand
- Mencampur bahasa tanpa alasan
- Menggunakan foto gepeng
- Membiarkan placeholder default saat showcase
- Membuat mobile view berantakan

---

## 28. Ringkasan

Desain Google Stitch yang diberikan sudah bagus dan cocok untuk website UMKM gift/custom. Desain ini perlu dijadikan acuan utama implementasi CI4, dengan beberapa revisi kecil: konsistensi nama brand, konsistensi bahasa, penambahan custom order di navbar, penggunaan foto produk asli, dan perencanaan filter katalog untuk mobile.
