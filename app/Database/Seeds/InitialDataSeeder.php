<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // ===== 1. ADMIN USER =====
        $this->db->table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@ayebouquet.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'superadmin',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // TODO: ganti nama/email/phone dengan data pelanggan asli sebelum deploy
        $this->db->table('users')->insert([
            'name'       => 'Pelanggan Demo',
            'email'      => 'pelanggan@example.com',
            'phone'      => '628111222333',
            'password'   => password_hash('user12345', PASSWORD_DEFAULT),
            'role'       => 'user',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // ===== 2. CATEGORIES =====
        $categories = [
            ['name' => 'Buket Bunga',  'slug' => 'buket-bunga',  'icon' => 'local_florist',  'sort_order' => 1, 'description' => 'Rangkaian buket bunga segar dan artificial untuk berbagai momen spesial.'],
            ['name' => 'Buket Uang',   'slug' => 'buket-uang',   'icon' => 'payments',       'sort_order' => 2, 'description' => 'Buket kreatif dari lembaran uang, cocok untuk hadiah wisuda dan ulang tahun.'],
            ['name' => 'Buket Snack',  'slug' => 'buket-snack',  'icon' => 'lunch_dining',   'sort_order' => 3, 'description' => 'Rangkaian snack favorit yang dikemas cantik dalam bentuk buket.'],
            ['name' => 'Selempang',    'slug' => 'selempang',     'icon' => 'award_star',     'sort_order' => 4, 'description' => 'Selempang custom untuk wisuda, ulang tahun, dan momen spesial lainnya.'],
            ['name' => 'Bloom Box',    'slug' => 'bloom-box',     'icon' => 'inventory_2',    'sort_order' => 5, 'description' => 'Kotak bunga elegan untuk hadiah romantis dan dekorasi.'],
            ['name' => 'Custom Gift',  'slug' => 'custom-gift',   'icon' => 'redeem',         'sort_order' => 6, 'description' => 'Kreasi hadiah custom sesuai keinginan dan budget Anda.'],
        ];

        foreach ($categories as $cat) {
            $cat['is_active']  = 1;
            $cat['created_at'] = date('Y-m-d H:i:s');
            $cat['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('categories')->insert($cat);
        }

        // ===== 3. PRODUCTS =====
        $products = [
            // Buket Bunga (category_id = 1)
            ['category_id' => 1, 'name' => 'Premium Rose & Lily Arrangement', 'slug' => 'premium-rose-lily-arrangement',  'sku' => 'BKT-001', 'description' => 'Buket mewah dengan kombinasi mawar dan lily segar. Packaging premium dengan pita satin.', 'price' => 250000, 'status' => 'ready',     'is_featured' => 1],
            ['category_id' => 1, 'name' => 'Sunflower Delight Bouquet',       'slug' => 'sunflower-delight-bouquet',      'sku' => 'BKT-002', 'description' => 'Buket bunga matahari cerah yang membawa semangat dan kebahagiaan.', 'price' => 180000, 'status' => 'ready',     'is_featured' => 0],
            ['category_id' => 1, 'name' => 'Elegant Tulip Garden',            'slug' => 'elegant-tulip-garden',           'sku' => 'BKT-003', 'description' => 'Rangkaian tulip warna-warni dalam wrapping kertas premium.', 'price' => 200000, 'status' => 'ready',     'is_featured' => 1],
            ['category_id' => 1, 'name' => 'Dried Flower Vintage Bouquet',    'slug' => 'dried-flower-vintage-bouquet',   'sku' => 'BKT-004', 'description' => 'Buket bunga kering dengan sentuhan vintage yang awet dan cantik.', 'price' => 150000, 'status' => 'ready',     'is_featured' => 0],

            // Buket Uang (category_id = 2)
            ['category_id' => 2, 'name' => 'Money Bouquet Tower',             'slug' => 'money-bouquet-tower',            'sku' => 'MNY-024', 'description' => 'Buket uang bertingkat dengan desain elegan untuk hadiah wisuda.', 'price' => 500000, 'status' => 'pre-order', 'is_featured' => 1],
            ['category_id' => 2, 'name' => 'Classic Money Roll Bouquet',      'slug' => 'classic-money-roll-bouquet',     'sku' => 'MNY-025', 'description' => 'Buket uang digulung rapi dengan hiasan bunga artificial.', 'price' => 300000, 'status' => 'ready',     'is_featured' => 0],
            ['category_id' => 2, 'name' => 'Fan Style Money Arrangement',     'slug' => 'fan-style-money-arrangement',   'sku' => 'MNY-026', 'description' => 'Uang disusun kipas cantik dengan rangkaian bunga segar.', 'price' => 400000, 'status' => 'ready',     'is_featured' => 0],

            // Buket Snack (category_id = 3)
            ['category_id' => 3, 'name' => 'Choco Lover Snack Bouquet',       'slug' => 'choco-lover-snack-bouquet',      'sku' => 'SNK-010', 'description' => 'Buket penuh coklat premium untuk pecinta manis.', 'price' => 120000, 'status' => 'ready',     'is_featured' => 1],
            ['category_id' => 3, 'name' => 'Mix Snack Party Bouquet',         'slug' => 'mix-snack-party-bouquet',        'sku' => 'SNK-011', 'description' => 'Kombinasi snack populer dalam buket meriah.', 'price' => 100000, 'status' => 'ready',     'is_featured' => 0],

            // Selempang (category_id = 4)
            ['category_id' => 4, 'name' => 'Selempang Wisuda Elegant Gold',   'slug' => 'selempang-wisuda-elegant-gold',  'sku' => 'SLP-005', 'description' => 'Selempang wisuda dengan aksen emas elegan.', 'price' => 75000,  'status' => 'ready',     'is_featured' => 0],
            ['category_id' => 4, 'name' => 'Selempang Birthday Custom',       'slug' => 'selempang-birthday-custom',      'sku' => 'SLP-006', 'description' => 'Selempang ulang tahun custom dengan nama dan desain pilihan.', 'price' => 60000,  'status' => 'ready',     'is_featured' => 0],

            // Bloom Box (category_id = 5)
            ['category_id' => 5, 'name' => 'Rose Garden Bloom Box',           'slug' => 'rose-garden-bloom-box',          'sku' => 'BBX-015', 'description' => 'Kotak bunga mawar dalam box premium bertutup kaca.', 'price' => 220000, 'status' => 'ready',     'is_featured' => 1],
            ['category_id' => 5, 'name' => 'Eternal Preserved Bloom Box',     'slug' => 'eternal-preserved-bloom-box',    'sku' => 'BBX-016', 'description' => 'Bloom box dengan bunga preserved yang tahan lama hingga 1 tahun.', 'price' => 350000, 'status' => 'pre-order', 'is_featured' => 1],

            // Custom Gift (category_id = 6)
            ['category_id' => 6, 'name' => 'Dried Flower Frame 3D',           'slug' => 'dried-flower-frame-3d',          'sku' => 'FRM-011', 'description' => 'Bingkai 3D dengan bunga kering untuk dekorasi dan hadiah.', 'price' => 180000, 'status' => 'habis',     'is_featured' => 0],
            ['category_id' => 6, 'name' => 'Custom Hampers Gift Set',         'slug' => 'custom-hampers-gift-set',        'sku' => 'GFT-020', 'description' => 'Hampers custom berisi produk pilihan Anda.', 'price' => 200000, 'status' => 'ready',     'is_featured' => 1],
            ['category_id' => 6, 'name' => 'Scrapbook Memory Box',            'slug' => 'scrapbook-memory-box',           'sku' => 'GFT-021', 'description' => 'Kotak kenangan dengan scrapbook custom foto dan pesan.', 'price' => 150000, 'status' => 'ready',     'is_featured' => 0],
        ];

        foreach ($products as $product) {
            $product['is_active']  = 1;
            $product['sort_order'] = 0;
            $product['created_at'] = date('Y-m-d H:i:s');
            $product['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('products')->insert($product);
        }

        // ===== 4. PRODUCT VARIANTS =====
        $variants = [
            // Product 1: Premium Rose & Lily
            ['product_id' => 1, 'size_label' => 'M',     'price' => 250000, 'sort_order' => 1],
            ['product_id' => 1, 'size_label' => 'L',     'price' => 350000, 'sort_order' => 2],
            ['product_id' => 1, 'size_label' => 'XL',    'price' => 450000, 'sort_order' => 3],
            // Product 2: Sunflower Delight
            ['product_id' => 2, 'size_label' => 'S',     'price' => 120000, 'sort_order' => 1],
            ['product_id' => 2, 'size_label' => 'M',     'price' => 180000, 'sort_order' => 2],
            ['product_id' => 2, 'size_label' => 'L',     'price' => 250000, 'sort_order' => 3],
            // Product 3: Elegant Tulip
            ['product_id' => 3, 'size_label' => 'M',     'price' => 200000, 'sort_order' => 1],
            ['product_id' => 3, 'size_label' => 'L',     'price' => 280000, 'sort_order' => 2],
            // Product 5: Money Bouquet Tower
            ['product_id' => 5, 'size_label' => 'L',     'price' => 500000, 'sort_order' => 1],
            ['product_id' => 5, 'size_label' => 'XL',    'price' => 750000, 'sort_order' => 2],
            ['product_id' => 5, 'size_label' => 'Jumbo', 'price' => 1000000, 'sort_order' => 3],
            // Product 8: Choco Lover
            ['product_id' => 8, 'size_label' => 'S',     'price' => 80000,  'sort_order' => 1],
            ['product_id' => 8, 'size_label' => 'M',     'price' => 120000, 'sort_order' => 2],
            ['product_id' => 8, 'size_label' => 'L',     'price' => 170000, 'sort_order' => 3],
            // Product 12: Rose Garden Bloom Box
            ['product_id' => 12, 'size_label' => 'M',    'price' => 220000, 'sort_order' => 1],
            ['product_id' => 12, 'size_label' => 'L',    'price' => 300000, 'sort_order' => 2],
            // Product 14: Dried Flower Frame
            ['product_id' => 14, 'size_label' => '8R',   'price' => 180000, 'sort_order' => 1],
            ['product_id' => 14, 'size_label' => '10R',  'price' => 250000, 'sort_order' => 2],
        ];

        foreach ($variants as $variant) {
            $variant['is_active']  = 1;
            $variant['created_at'] = date('Y-m-d H:i:s');
            $variant['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('product_variants')->insert($variant);
        }

        // ===== 5. TESTIMONIALS =====
        $testimonials = [
            ['customer_name' => 'Ananda Putri',    'message' => 'Buket bunganya sangat wangi dan rapi banget! Suka sekali sama wrappingnya, premium banget. Pasti order lagi!', 'rating' => 5, 'product_id' => 1, 'is_approved' => 1],
            ['customer_name' => 'Rian Pratama',     'message' => 'Hasil customnya sesuai budget dan pengerjaannya cepat. Selempang wisudanya bagus, teman saya suka banget!', 'rating' => 4, 'product_id' => 10, 'is_approved' => 1],
            ['customer_name' => 'Dewi Lestari',     'message' => 'Bloom box-nya cantik banget, bunganya awet dan wangi. Packagingnya juga rapi. Recommended!', 'rating' => 5, 'product_id' => 12, 'is_approved' => 1],
            ['customer_name' => 'Budi Santoso',     'message' => 'Buket uangnya keren banget, teman saya yang wisuda sangat senang. Desainnya unik dan kreatif.', 'rating' => 5, 'product_id' => 5, 'is_approved' => 1],
            ['customer_name' => 'Siti Rahmawati',   'message' => 'Buket snacknya lucu dan isinya banyak! Anak saya senang sekali. Harganya juga terjangkau.', 'rating' => 5, 'product_id' => 8, 'is_approved' => 1],
            ['customer_name' => 'Rudi Hartono',     'message' => 'Hampers-nya lengkap dan dikemas cantik. Cocok banget buat hadiah. Next order lagi ya!', 'rating' => 4, 'product_id' => 15, 'is_approved' => 1],
            ['customer_name' => 'Nisa Amelia',      'message' => 'Buket bunga tulip-nya cantik banget, warnanya cerah. Pacar saya suka banget! Terima kasih.', 'rating' => 5, 'product_id' => 3, 'is_approved' => 1],
            ['customer_name' => 'Ahmad Fauzi',      'message' => 'Pengerjaan agak lama tapi hasilnya memuaskan. Semoga bisa lebih cepat lagi ya.', 'rating' => 3, 'product_id' => 14, 'is_approved' => 0],
        ];

        foreach ($testimonials as $testi) {
            $testi['created_at'] = date('Y-m-d H:i:s');
            $testi['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('testimonials')->insert($testi);
        }

        // ===== 6. SETTINGS =====
        // TODO: ganti contact_whatsapp, contact_address dengan data asli sebelum deploy
        $settings = [
            ['key' => 'site_name',        'value' => 'Aye Bouquet',        'group' => 'general'],
            ['key' => 'site_tagline',     'value' => 'Hadiah Custom untuk Momen Spesial', 'group' => 'general'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'contact_email',    'value' => 'halo@ayebouquet.com', 'group' => 'contact'],
            ['key' => 'contact_address',  'value' => 'Jl. Kreatif No. 12, Kota Bandung', 'group' => 'contact'],
            ['key' => 'contact_instagram','value' => 'ayebouquet', 'group' => 'contact'],
            ['key' => 'contact_tiktok',   'value' => '', 'group' => 'contact'],
            ['key' => 'contact_marketplace', 'value' => '', 'group' => 'contact'],
            ['key' => 'google_maps_link', 'value' => 'https://www.google.com/maps', 'group' => 'contact'],
            ['key' => 'google_maps_embed','value' => '', 'group' => 'contact'],
            ['key' => 'working_hours',    'value' => 'Senin - Sabtu, 09:00 - 18:00 WIB', 'group' => 'contact'],
            ['key' => 'pickup_hours',     'value' => '10:00 - 17:00 WIB', 'group' => 'contact'],
            ['key' => 'delivery_hours',   'value' => 'Menyesuaikan jadwal kurir', 'group' => 'contact'],
            ['key' => 'footer_text',      'value' => 'Hadiah custom untuk momen spesial Anda.', 'group' => 'contact'],
            ['key' => 'delivery_info',    'value' => 'Pesanan dapat diambil langsung di toko atau dikirim menggunakan kurir lokal. Ongkos kirim akan dikonfirmasi via WhatsApp sesuai alamat tujuan. Untuk produk custom dan pre-order, pemesanan disarankan dilakukan minimal H-1/H-2 sebelum acara.', 'group' => 'product_info'],
            ['key' => 'order_guide',      'value' => 'Pilih produk dan varian ukuran, isi catatan custom jika diperlukan, tambahkan ke keranjang, lalu checkout. Setelah checkout, Anda akan diarahkan ke WhatsApp untuk konfirmasi stok, ongkir, dan pembayaran manual.', 'group' => 'product_info'],
            ['key' => 'processing_estimate', 'value' => 'Estimasi pengerjaan 1-3 hari kerja tergantung tingkat kerumitan custom.', 'group' => 'product_info'],
            ['key' => 'preorder_note',    'value' => 'Produk pre-order diproses setelah detail pesanan dan pembayaran dikonfirmasi.', 'group' => 'product_info'],
            ['key' => 'free_item_info',   'value' => 'Kartu ucapan gratis dapat ditambahkan pada catatan pesanan; tas jinjing mengikuti stok toko.', 'group' => 'product_info'],

            // Backward compatibility keys untuk kode lama.
            // TODO: ganti nomor WA dengan nomor asli sebelum deploy
            ['key' => 'whatsapp_number',  'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'instagram_url',    'value' => 'ayebouquet', 'group' => 'contact'],
            ['key' => 'email',            'value' => 'halo@ayebouquet.com', 'group' => 'contact'],
            ['key' => 'address',          'value' => 'Jl. Kreatif No. 12, Kota Bandung', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            $setting['created_at'] = date('Y-m-d H:i:s');
            $setting['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('settings')->insert($setting);
        }
    }
}
