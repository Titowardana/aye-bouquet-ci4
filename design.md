# design.md — Panduan Desain Aye Bouquet

## 1. Status Desain

Dokumen ini adalah panduan desain untuk project **Aye Bouquet**, website katalog dan pemesanan produk gift/custom UMKM melalui WhatsApp.

Project sudah berjalan dengan fitur inti:
- Katalog produk dengan filter (kategori, ukuran, harga, warna, status)
- Keranjang berbasis session
- Checkout dengan redirect WhatsApp
- Custom Order
- Testimoni dengan approval admin
- Admin dashboard (produk, kategori, warna, opsi custom, testimoni, galeri, FAQ, kontak, orders)
- Dark mode (khususnya admin sudah baik)
- Auth ganda (customer + admin)

**Fokus desain selanjutnya:** memperbaiki frontend light mode yang masih terlalu dominan putih, tanpa mengubah dark mode dan tanpa mengubah logic fitur yang sudah berjalan.

Konsep utama desain:

```text
Soft, clean, modern, elegant, feminin, hangat, dan mudah digunakan.
```

---

## 2. Aturan Utama Perubahan Desain

Setiap perubahan desain WAJIB mematuhi aturan berikut:

1. **Jangan mengubah logic** — route, controller, model, migration, database, session, cart, checkout, order, WhatsApp, login, register tetap seperti adanya.
2. **Jangan menghapus csrf_field()**, action, method, name, id, value, selected, checked, required, enctype, atau atribut penting form.
3. **Jangan menambah library/CDN baru** — gunakan Tailwind CDN, Material Symbols, SweetAlert2, Animate.css yang sudah ada.
4. **Dark mode jangan dirombak besar-besaran** — hanya perbaikan visual kecil jika diperlukan.
5. **Jangan merombak total** — lakukan perubahan bertahap dan terukur.

---

## 3. Brand

| Atribut | Nilai |
|---|---|
| Nama brand | **Aye Bouquet** |
| Tidak boleh diganti | Aye Bouquet (hardcode di layout sudah pakai title/view data) |
| Nama tersimpan di | title/view data, bukan hardcode di setiap file |

---

## 4. Bahasa

Seluruh antarmuka frontend menggunakan **Bahasa Indonesia**:

```text
Beranda
Katalog
Custom Order
Testimoni
Tentang Kami
Kontak
```

Menu Custom Order sudah ada di navbar. Jangan menghapus atau mengganti menu ini.

---

## 5. Palet Warna — Light Mode

Light mode saat ini terlalu dominan putih. Perbaiki dengan palet berikut:

```text
Primary Mauve (brand)   : #795465  — tombol, heading, active menu, pagination
Dusty Mauve             : #8B5E6E  — variant, hover state
Warm Blush              : #FBF0ED  — background section alternating
Soft Pink               : #F8E1DE  — icon background, aksen lembut
Cream                   : #FAF5F2  — background section utama
White Warm Card         : #FFFBF9  — background card/container
Soft Beige              : #E8E3DE  — border halus, footer background
White                   : #FFFFFF  — hanya untuk area yang memerlukan kontras tinggi
Text Dark               : #1F1F1F  — body text
Text Muted              : #6F6F6F  — secondary text
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

Aturan penggunaan:
- **Background section**: jangan semua putih polos. Gunakan alternating:
  - Section 1: Cream (`#FAF5F2`)
  - Section 2: Warm Blush (`#FBF0ED`)
  - Section 3: Cream lagi, dan seterusnya
- **Card produk**: White Warm Card (`#FFFBF9`) dengan border soft dan shadow lembut
- **Heading & tombol utama**: Primary Mauve
- **Aksen lembut**: Soft Pink untuk icon, badge, highlight ringan
- **Border**: gunakan Soft Beige atau `border-outline-variant/20`

---

## 6. Palet Warna — Dark Mode

Dark mode sudah cukup baik dan **jangan dirombak besar-besaran**.

Warna dark mode existing (pertahankan):

```text
Background utama       : #1C191A
Card                   : #2A2028
Border                 : rgba(255,255,255,0.08)
Text utama             : #FFFFFF
Text muted             : rgba(255,255,255,0.6)
```

Hanya perbaiki bug visual kecil jika ditemukan (teks tidak terbaca, kontras kurang, padding tidak konsisten).

---

## 7. Typography

Font yang digunakan saat ini (pertahankan):

```text
Plus Jakarta Sans      — font utama (sudah via CDN)
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

## 8. Section Background — Panduan Alternating

Agar light mode tidak monoton putih, gunakan pola background berselang-seling:

```text
Section Hero          : Warm Blush (#FBF0ED) dengan gradient overlay
Section Kategori      : Cream (#FAF5F2)
Section Produk Populer: Warm Blush (#FBF0ED)
Section Testimoni     : Cream (#FAF5F2)
Section Footer        : Soft Beige (#E8E3DE) atau Dusty Mauve
```

Untuk halaman internal (Katalog, Custom Order, dll):
- Background utama: Cream (`#FAF5F2`) atau White Warm Card (`#FFFBF9`)
- Card/container: White Warm Card dengan soft shadow
- Jangan gunakan putih murni (`#FFFFFF`) untuk background halaman penuh

---

## 9. Panduan Halaman Frontend

### 9.1 Homepage / Beranda

Urutan section:
1. Navbar
2. Hero section
3. Kategori pilihan
4. Produk terpopuler (maksimal 8 produk)
5. Testimonial pelanggan (3 testimonial)
6. Footer

Aturan produk populer:
- Maksimal **8 produk** ditampilkan
- Produk dengan status **Habis** tidak ditampilkan sebagai produk populer
- Gunakan produk dengan status **Unggulan / Featured** jika ada, atau produk aktif dengan status Ready/Pre-order
- Jika produk unggulan kosong, tampilkan produk aktif terbaru

### 9.2 Katalog

Layout:
```text
Desktop: Sidebar filter kiri + grid produk kanan
Mobile : Search + tombol filter di atas, grid produk di bawah (filter jadi offcanvas/modal)
```

Sidebar filter sudah berjalan dengan filter:
- Kategori (dari database)
- Ukuran (dari database)
- Rentang harga
- **Warna (dari tabel `product_colors` — hanya warna aktif)**
- Status produk

**Filter warna — aturan baru:**
- Warna berasal dari tabel `product_colors`
- Hanya warna dengan `is_active = 1` yang ditampilkan
- Tampilkan swatch bulat menggunakan `hex_code`
- **Jangan hardcode daftar warna** di view
- Jika tidak ada warna aktif, filter warna boleh disembunyikan

### 9.3 Custom Order

Halaman custom order sudah berjalan. Pertahankan form dan logika yang ada.

Perbaikan visual yang mungkin:
- Card form menggunakan White Warm Card
- Alternating background antar section form jika panjang

### 9.4 Testimoni

Halaman testimoni publik sudah menampilkan testimonial yang sudah di-approve.

Aturan:
- Card testimoni: White Warm Card dengan soft shadow
- Background section: Cream
- Foto pelanggan: `w-32 h-32` dengan lightbox global
- Rating bintang aktif: warna primary mauve, tidak aktif: gray-300
- Jika belum ada testimoni: tampilkan empty state "Belum ada ulasan"

### 9.5 Tentang Kami

Halaman profil brand.

Aturan visual:
- Alternating background antar section
- Foto/visual brand dengan rounded corner
- Teks mudah dibaca, gunakan text-dark (`#1F1F1F`)
- Hindari putih polos di background

### 9.6 Kontak

Halaman kontak dan lokasi.

Aturan:
- Card informasi kontak: White Warm Card
- Background: Cream
- Nomor WhatsApp dari database (tabel settings) — jangan hardcode
- Google Maps jika tersedia

---

## 10. Navbar

```text
Isi navbar:
[Logo Aye Bouquet] [Beranda] [Katalog] [Custom Order] [Kontak] [Cart Icon] [User Icon]
```

Aturan desain:
- Background putih dengan border bawah halus.
- Menu aktif: underline warna mauve.
- Cart icon dan user icon: warna mauve.
- Mobile: hamburger menu.
- Jangan tambah menu baru tanpa diskusi.

---

## 11. Hero Section

Hero section dengan background gambar buket + overlay.

Komponen:
- Badge kecil: "Momen Spesial, Kado Spesial"
- Judul: "Pesan Buket dan Gift Custom Sesuai Keinginanmu"
- Deskripsi singkat
- Tombol "Belanja Sekarang" (mauve solid)
- Tombol "Buat Custom Order" (outline)

Aturan:
- Background: Warm Blush dengan overlay soft.
- Mobile tetap rapi, tidak terlalu tinggi.
- Tombol mudah di-tap di mobile.

---

## 12. Produk Terpopuler

- Maksimal 8 produk.
- Produk Habis tidak ditampilkan.
- Gunakan produk featured/unggulan jika ada.
- Jika tidak ada produk unggulan, gunakan produk aktif terbaru.

Card produk:
```text
Foto produk
Badge status (kanan atas)
Nama produk
Kategori
Mulai dari Rp...
```

Aturan:
- Card: White Warm Card, rounded-2xl, shadow lembut.
- Harga: bold, warna mauve.
- Foto: object-fit cover, aspect ratio konsisten.

---

## 13. Sidebar Filter — Warna

**PENTING — Filter warna sudah dinamis:**

```php
// Contoh logika (jangan diubah):
$colorModel = new \App\Models\ProductColorModel();
$colors = $colorModel->getActiveColors(); // hanya is_active = 1
```

Di view:
```text
@foreach ($colors as $color)
  <label>
    <input type="checkbox" name="warna[]" value="{{ $color['name'] }}">
    <span class="w-4 h-4 rounded-full" style="background-color: {{ $color['hex_code'] }}"></span>
    {{ $color['name'] }}
  </label>
@endforeach
```

Aturan:
- **Jangan hardcode** daftar warna.
- Gunakan `hex_code` untuk swatch.
- Hanya warna aktif (`is_active = 1`) yang tampil.
- Urut berdasarkan `sort_order` ASC, lalu `name` ASC.

---

## 14. Admin

Admin sudah cukup baik. Catatan:

1. **Dark mode admin jangan dirombak** — sudah menggunakan palet ungu gelap yang konsisten.
2. **Light mode admin** boleh diperbaiki jika ada bug visual (teks tidak terbaca, padding tidak rapi, tombol tidak jelas).
3. **Perubahan admin hanya untuk bug visual kecil** — jangan mengubah layout, sidebar, tabel, atau form yang sudah berjalan.
4. Jangan mengubah logic CRUD, filter, search, toggle status, upload, atau export.

---

## 15. Card Produk (Katalog)

Aturan visual:
- Background: White Warm Card (`#FFFBF9`)
- Border-radius: 16px — 20px
- Shadow: lembut (`shadow-sm`)
- Foto: object-fit cover, aspect ratio 1:1 atau 4:3 konsisten
- Badge status: pojok kanan atas foto
- Harga: bold, warna mauve
- Tombol "Lihat Detail": outline pill

---

## 16. Responsive Design

Breakpoint:
```text
Mobile  : < 640px
Tablet  : 640px - 1023px
Desktop : >= 1024px
```

Aturan mobile:
- Navbar hamburger
- Hero satu kolom
- Kategori: horizontal scroll atau 2 kolom
- Produk: 1-2 kolom
- Filter katalog: offcanvas/modal (bukan sidebar tetap)
- Form: full width
- Footer: satu kolom

---

## 17. Larangan Desain

Jangan:
- Mengubah warna brand (mauve #795465)
- Menggunakan warna neon atau mencolok di luar tema
- Menghilangkan filter katalog
- Menghilangkan tombol WhatsApp
- Mencampur bahasa tanpa alasan
- Membiarkan foto produk gepeng
- Membuat mobile view berantakan
- Menambahkan rating/review palsu atau dummy
- Menampilkan produk Habis sebagai produk populer
- Menghardcode warna filter di view

---

## 18. Checklist Testing Visual — Light Mode

Setelah perubahan desain light mode, WAJIB test:

### 18.1 Homepage
- [ ] Hero section: background Warm Blush, teks terbaca, tombol jelas
- [ ] Kategori: card rapi, icon pink, responsive
- [ ] Produk populer: maks 8, tidak ada produk Habis, card putih hangat
- [ ] Testimoni: card cream/putih hangat, rating bintang mauve
- [ ] Footer: background soft beige/konsisten

### 18.2 Katalog
- [ ] Background halaman: Cream/White Warm, bukan putih polos
- [ ] Sidebar filter: card putih hangat, filter warna dari database
- [ ] Swatch warna: bulat, pakai hex_code, hanya warna aktif
- [ ] Grid produk: card putih hangat, shadow lembut
- [ ] Pagination: mauve untuk active

### 18.3 Custom Order
- [ ] Background: alternating cream/blush
- [ ] Card form: putih hangat, rounded
- [ ] Tombol WhatsApp: jelas

### 18.4 Testimoni
- [ ] Background: cream
- [ ] Card testimoni: putih hangat
- [ ] Foto: ukuran konsisten, lightbox berfungsi
- [ ] Empty state jika tidak ada testimoni

### 18.5 Tentang Kami
- [ ] Background: alternating
- [ ] Teks mudah dibaca

### 18.6 Kontak
- [ ] Background: cream
- [ ] Info kontak: card putih hangat
- [ ] Nomor WhatsApp dari database

### 18.7 Mobile Responsive
- [ ] Navbar hamburger berfungsi
- [ ] Hero tidak terlalu tinggi
- [ ] Kategori horizontal scroll
- [ ] Produk 1-2 kolom rapi
- [ ] Filter katalog offcanvas/modal
- [ ] Form full width
- [ ] Footer satu kolom

### 18.8 Dark Mode Tidak Rusak
- [ ] Homepage dark mode masih terbaca
- [ ] Katalog dark mode masih konsisten
- [ ] Semua halaman dark mode tidak ada perubahan tidak sengaja

---

## 19. Ringkasan

Project Aye Bouquet sudah memiliki fitur lengkap. Fokus desain saat ini adalah **memperhalus light mode frontend** agar tidak terlalu putih, dengan:
- Alternating background (Warm Blush, Cream)
- White Warm Card untuk card/container
- Warna brand mauve konsisten
- Filter warna dinamis dari database
- Produk populer maksimal 8, tanpa produk Habis
- Dark mode tetap seperti adanya
- Semua perubahan tanpa mengubah logic, route, controller, model, database, atau fitur yang sudah berjalan
