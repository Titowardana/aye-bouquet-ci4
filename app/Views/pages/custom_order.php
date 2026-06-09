<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .soft-shadow {
        box-shadow: 0 4px 20px rgba(121, 84, 101, 0.05); /* Primary-Tinted Grey */
    }
    .soft-shadow-hover:hover {
        box-shadow: 0 8px 30px rgba(121, 84, 101, 0.1);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>

<div class="w-full max-w-[1280px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-12 md:py-20 flex flex-col gap-section-gap">
    <!-- Page Header -->
    <section class="text-center max-w-2xl mx-auto space-y-4">
        <h1 class="font-display-lg text-4xl md:text-5xl font-bold text-primary dark:text-primary-fixed-dim tracking-tight">Custom Order</h1>
        <p class="font-body-lg text-lg text-on-surface-variant dark:text-white/70">Buat pesanan gift sesuai keinginanmu. Ceritakan detailnya, dan biarkan kami merangkai kehangatan untuk momen spesialmu.</p>
    </section>

    <!-- Form Section -->
    <section class="max-w-3xl mx-auto w-full">
        <form class="space-y-8" id="customOrderForm">
            <!-- Product Details Card -->
            <div class="bg-surface-container-lowest dark:bg-[#262024] rounded-xl soft-shadow p-6 md:p-8 space-y-8 card-hover">
                <h2 class="font-headline-md text-2xl font-bold text-on-surface dark:text-white border-b border-outline-variant dark:border-white/10 pb-4">Detail Produk</h2>
                
                <!-- Product Type -->
                <div class="space-y-3">
                    <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block">Jenis Produk</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php if (!empty($categories) && is_array($categories)): ?>
                            <?php foreach ($categories as $index => $category): ?>
                                <label class="cursor-pointer">
                                    <input <?= $index === 0 ? 'checked' : '' ?> class="peer sr-only" name="product_type" type="radio" value="<?= esc($category['name']) ?>">
                                    <div class="p-4 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 text-center hover:bg-surface-container dark:hover:bg-white/10 transition-colors peer-checked:border-primary peer-checked:bg-primary-container/20 dark:peer-checked:bg-primary/20 peer-checked:text-primary font-body-md text-base dark:text-white flex flex-col items-center justify-center gap-2">
                                        <?php
                                        $catIcon = $category['icon'] ?? '';
                                        $catIconIsFile = !empty($catIcon) && preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $catIcon);
                                        $catIconFilePath = FCPATH . 'uploads/categories/' . $catIcon;
                                        ?>
                                        <?php if ($catIconIsFile && file_exists($catIconFilePath)): ?>
                                            <img src="<?= base_url('uploads/categories/' . esc($catIcon)) ?>" alt="" class="w-7 h-7 object-contain mx-auto mb-2">
                                        <?php elseif (!empty($catIcon)): ?>
                                            <span class="material-symbols-outlined text-2xl mb-2"><?= esc($catIcon) ?></span>
                                        <?php else: ?>
                                            <span class="material-symbols-outlined text-2xl mb-2">category</span>
                                        <?php endif; ?>
                                        <span><?= esc($category['name']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-2 md:col-span-3 p-4 text-center border border-dashed border-outline-variant dark:border-white/15 rounded-lg text-on-surface-variant dark:text-white/70 text-sm">
                                Belum ada kategori aktif untuk custom order.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Size Selection -->
                <div class="space-y-3">
                    <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block">Ukuran</label>
                    <div class="flex flex-wrap gap-3">
                        <?php if (!empty($sizeOptions)): ?>
                            <?php foreach ($sizeOptions as $idx => $size): ?>
                                <label class="cursor-pointer">
                                    <input <?= $idx === 0 ? 'checked' : '' ?> class="peer sr-only" name="size" type="radio" value="<?= esc($size['name']) ?>">
                                    <div class="px-6 py-2 rounded-full border border-outline-variant dark:border-white/15 bg-surface-container-low dark:bg-white/10 text-on-surface-variant dark:text-white/70 hover:bg-surface-container dark:hover:bg-white/20 transition-colors peer-checked:bg-primary peer-checked:text-on-primary peer-checked:border-primary font-label-md text-sm font-bold"><?= esc($size['name']) ?></div>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-sm text-on-surface-variant italic w-full">Belum ada opsi ukuran tersedia.</p>
                            <input type="text" name="size_manual" id="size_manual" class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white" placeholder="Masukkan ukuran (S/M/L/dll)">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Budget -->
                    <div class="space-y-2">
                        <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="budget">Estimasi Budget</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant dark:text-white/60 font-body-md text-base">Rp</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="budget" name="budget" placeholder="Contoh: 150.000" type="text">
                        </div>
                    </div>
                    
                    <!-- Logistics -->
                    <div class="space-y-2">
                        <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="date">Tanggal Dibutuhkan</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant dark:text-white/60">calendar_month</span>
                            <input class="w-full pl-12 pr-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white" id="date" name="date" type="date">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customization Card -->
            <div class="bg-surface-container-lowest dark:bg-[#262024] rounded-xl soft-shadow p-6 md:p-8 space-y-8 card-hover">
                <h2 class="font-headline-md text-2xl font-bold text-on-surface dark:text-white border-b border-outline-variant dark:border-white/10 pb-4">Gaya & Tema</h2>
                
                <div class="space-y-4 mb-6">
                    <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block">Warna/Tema Pilihan</label>
                    <div class="flex flex-wrap gap-2">
                        <?php if (!empty($colorOptions)): ?>
                            <?php foreach ($colorOptions as $color): ?>
                                <label class="cursor-pointer">
                                    <input class="peer sr-only color-checkbox" type="checkbox" value="<?= esc($color['name']) ?>">
                                    <div class="px-4 py-1.5 rounded-full border border-outline-variant dark:border-white/15 bg-surface-container-low dark:bg-white/10 text-on-surface-variant dark:text-white/70 hover:bg-surface-container dark:hover:bg-white/20 transition-colors peer-checked:bg-primary peer-checked:text-on-primary peer-checked:border-primary font-label-sm text-xs font-bold"><?= esc($color['name']) ?></div>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-xs text-on-surface-variant italic">Belum ada preset warna.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="warna">Warna Dominan Manual</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="warna" name="warna" placeholder="Contoh: Pink pastel dan Putih" type="text">
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="tema">Tema Acara</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="tema" name="tema" placeholder="Contoh: Ulang Tahun, Wisuda" type="text">
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="bahan">Jenis Bunga / Bahan Prioritas</label>
                    <input class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="bahan" name="bahan" placeholder="Contoh: Mawar asli, cokelat silverqueen, dll" type="text">
                </div>
                
                <!-- Extras -->
                <div class="space-y-4 pt-4 border-t border-outline-variant dark:border-white/10 border-dashed">
                    <h3 class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block">Add-on Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if (!empty($addonOptions)): ?>
                            <?php foreach ($addonOptions as $addon): ?>
                            <div class="flex items-center justify-between p-4 rounded-lg border border-outline-variant dark:border-white/15 bg-surface-container-low dark:bg-white/5">
                                <div>
                                    <p class="font-label-md text-sm font-bold text-on-surface dark:text-white"><?= esc($addon['name']) ?></p>
                                    <p class="font-label-sm text-xs text-on-surface-variant dark:text-white/60">
                                        <?= $addon['additional_price'] == 0 ? 'Gratis' : '+ Rp ' . number_format($addon['additional_price'], 0, ',', '.') ?>
                                    </p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer addon-checkbox" type="checkbox" data-name="<?= esc($addon['name']) ?>" data-price="<?= esc($addon['additional_price']) ?>">
                                    <div class="w-11 h-6 bg-outline-variant dark:bg-white/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-sm text-on-surface-variant italic col-span-1 md:col-span-2">Belum ada add-on tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="pesan">Isi Kartu Ucapan</label>
                    <textarea class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40 resize-none" id="pesan" name="pesan" placeholder="Tuliskan pesan manis untuk penerima..." rows="3"></textarea>
                </div>
            </div>

            <!-- Personal Details Card -->
            <div class="bg-surface-container-lowest dark:bg-[#262024] rounded-xl soft-shadow p-6 md:p-8 space-y-8 card-hover">
                <h2 class="font-headline-md text-2xl font-bold text-on-surface dark:text-white border-b border-outline-variant dark:border-white/10 pb-4">Data Pemesan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="nama">Nama Lengkap</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="nama" name="nama" placeholder="Nama Anda" type="text" required>
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="nohp">Nomor WhatsApp</label>
                        <input class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="nohp" name="nohp" placeholder="08xx xxxx xxxx" type="tel" required>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 block" for="catatan">Catatan Khusus (Opsional)</label>
                    <textarea class="w-full px-4 py-3 rounded-lg border border-outline-variant dark:border-white/15 bg-surface dark:bg-white/5 focus:border-primary focus:ring-2 focus:ring-primary-container focus:outline-none transition-all font-body-md text-base text-on-surface dark:text-white placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40 resize-none" id="catatan" name="catatan" placeholder="Ada instruksi tambahan?" rows="2"></textarea>
                </div>
            </div>

            <!-- Note & CTA -->
            <div class="space-y-6 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-surface-container-low dark:bg-white/5 border border-outline-variant dark:border-white/15 text-on-surface-variant dark:text-white/70 font-label-sm text-xs max-w-lg mx-auto text-left">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p>Jika memiliki referensi gambar, Anda dapat mengirimkannya melalui WhatsApp setelah menekan tombol di bawah.</p>
                </div>
                <button type="button" id="btn-submit-custom-order" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-primary text-on-primary font-label-md text-sm font-bold shadow-sm hover:bg-surface-tint hover:shadow-md active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-xl">send</span>
                    Kirim ke WhatsApp
                </button>
            </div>
        </form>
    </section>

    <!-- Portfolio Gallery -->
    <section class="mt-12 space-y-8 animate-on-scroll">
        <div class="text-center">
            <h2 class="font-headline-lg-mobile md:font-headline-lg text-2xl md:text-3xl font-bold text-primary dark:text-primary-fixed-dim">Contoh Hasil Custom Order</h2>
            <p class="font-body-md text-base text-on-surface-variant dark:text-white/60 mt-2">Inspirasi karya dari pelanggan sebelumnya.</p>
        </div>

        <?php if (!empty($galleries)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-stagger>
            <?php foreach ($galleries as $gallery): ?>
            <div class="bg-surface-container-lowest dark:bg-[#262024] rounded-xl soft-shadow overflow-hidden group card-hover">
                <div class="aspect-square bg-surface-variant dark:bg-[#2a2328] relative overflow-hidden">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         src="<?= base_url('uploads/galleries/' . $gallery['image']) ?>"
                         alt="<?= esc($gallery['title'] ?? 'Contoh Hasil Custom Order') ?>">
                </div>
                <div class="p-4 text-center">
                    <p class="font-label-md text-sm font-bold text-on-surface dark:text-white"><?= esc($gallery['title'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/40 dark:text-white/20 mb-4">photo_library</span>
            <p class="font-body-md text-base text-on-surface-variant dark:text-white/60">Belum ada contoh hasil custom order.</p>
        </div>
        <?php endif; ?>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btnSubmit = document.getElementById('btn-submit-custom-order');
        
        btnSubmit.addEventListener('click', () => {
            // Validate required fields
            const nama = document.getElementById('nama').value;
            const nohp = document.getElementById('nohp').value;
            
            if (!nama || !nohp) {
                alert('Silakan isi Nama Lengkap dan Nomor WhatsApp terlebih dahulu.');
                return;
            }

            // Get selected product type
            let productType = '';
            const typeRadios = document.getElementsByName('product_type');
            for(let i=0; i<typeRadios.length; i++){
                if(typeRadios[i].checked) { productType = typeRadios[i].value; break; }
            }

            // Get selected size
            let size = '';
            const sizeRadios = document.getElementsByName('size');
            if(sizeRadios && sizeRadios.length > 0) {
                for(let i=0; i<sizeRadios.length; i++){
                    if(sizeRadios[i].checked) { size = sizeRadios[i].value; break; }
                }
            } else {
                const manualSizeEl = document.getElementById('size_manual');
                if(manualSizeEl) size = manualSizeEl.value.trim();
            }

            // Get color checkboxes
            let selectedColors = [];
            const colorCheckboxes = document.querySelectorAll('.color-checkbox:checked');
            colorCheckboxes.forEach(cb => selectedColors.push(cb.value));

            // Get Add-ons
            let selectedAddons = [];
            let totalAddonPrice = 0;
            const addonCheckboxes = document.querySelectorAll('.addon-checkbox:checked');
            addonCheckboxes.forEach(cb => {
                const name = cb.getAttribute('data-name');
                const price = parseInt(cb.getAttribute('data-price') || 0);
                selectedAddons.push(name);
                totalAddonPrice += price;
            });

            // Construct WA Message
            let waLines = [];
            waLines.push(`Halo Admin Aye Bouquet, saya ingin melakukan Custom Order.`);
            waLines.push(``);
            waLines.push(`Detail Custom:`);

            if (productType) waLines.push(`- Jenis Produk: ${productType}`);
            if (size) waLines.push(`- Ukuran: ${size}`);

            const budgetVal = document.getElementById('budget').value.trim();
            if (budgetVal) waLines.push(`- Estimasi Budget: Rp ${budgetVal}`);

            const dateVal = document.getElementById('date').value.trim();
            if (dateVal) {
                const parts = dateVal.split('-');
                const formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                waLines.push(`- Tanggal Dibutuhkan: ${formattedDate}`);
            }

            const warnaVal = document.getElementById('warna').value.trim();
            const temaVal = document.getElementById('tema').value.trim();
            const bahanVal = document.getElementById('bahan').value.trim();

            let temaParts = [...selectedColors];
            if (warnaVal) temaParts.push(warnaVal);
            if (temaVal) temaParts.push(temaVal);
            if (temaParts.length) waLines.push(`- Tema/Warna: ${temaParts.join(', ')}`);

            if (bahanVal) waLines.push(`- Bahan Prioritas: ${bahanVal}`);

            if (selectedAddons.length > 0) {
                waLines.push(`- Tambahan: ${selectedAddons.join(', ')}`);
                if (totalAddonPrice > 0) {
                    waLines.push(`- Estimasi Biaya Tambahan: Rp ${totalAddonPrice.toLocaleString('id-ID')}`);
                }
            }

            const pesanVal = document.getElementById('pesan').value.trim();
            if (pesanVal) waLines.push(`- Isi Kartu Ucapan: ${pesanVal}`);

            waLines.push(``);
            waLines.push(`Data Pemesan:`);
            waLines.push(`- Nama: ${nama}`);
            waLines.push(`- WhatsApp: ${nohp}`);

            const catatanVal = document.getElementById('catatan').value.trim();
            if (catatanVal) waLines.push(`- Catatan: ${catatanVal}`);

            waLines.push(``);
            waLines.push(`Mohon konfirmasi ketersediaan, estimasi pengerjaan, total pembayaran, dan metode pembayaran. Terima kasih.`);

            const text = waLines.join('\n');

            const encodedText = encodeURIComponent(text);
            const adminWA = '<?= esc($waNumber ?? '6281234567890') ?>';
            const waUrl = `https://wa.me/${adminWA}?text=${encodedText}`;

            window.open(waUrl, '_blank');
        });
    });
</script>
<?= $this->endSection() ?>
