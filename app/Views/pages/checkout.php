<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$orderItems = $orderItems ?? [];
$subtotal = $subtotal ?? 0;
$totalItems = $totalItems ?? 0;
$waNumber = $waNumber ?? '6281234567890';
$phoneDisplay = preg_replace('/^(\+62|62|0)/', '', old('no_hp'));
?>

<style>
    .soft-shadow { box-shadow: 0 4px 20px rgba(121,84,101,0.06); }
    .form-input {
        width: 100%;
        border-radius: 0.75rem;
        border: 1px solid #d2c3c7;
        background: #ffffff;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        color: #1b1c1c;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .dark .form-input {
        background: #2a2428;
        border-color: rgba(255,255,255,0.15);
        color: #e6e0e4;
    }
    .form-input:focus {
        border-color: #795465;
        box-shadow: 0 0 0 3px rgba(121,84,101,0.12);
    }
    .dark .form-input:focus {
        border-color: #a87d8f;
        box-shadow: 0 0 0 3px rgba(121,84,101,0.3);
    }
    .form-input::placeholder { color: rgba(79,68,72,0.4); }
    .dark .form-input::placeholder { color: rgba(230,224,228,0.4); }
    .step-badge {
        width: 28px; height: 28px;
        background: #f8c8dc;
        color: #795465;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 12px; flex-shrink: 0;
    }
    .dark .step-badge {
        background: rgba(121,84,101,0.4);
        color: #f8c8dc;
    }
</style>

<div class="w-full px-6 md:px-12 lg:px-16 mx-auto py-10 md:py-14">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-on-surface-variant/80 mb-8">
        <a href="<?= base_url('/') ?>" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span> Beranda
        </a>
        <span class="material-symbols-outlined text-[12px] text-outline-variant">chevron_right</span>
        <a href="<?= base_url('/keranjang') ?>" class="hover:text-primary transition-colors">Keranjang</a>
        <span class="material-symbols-outlined text-[12px] text-outline-variant">chevron_right</span>
        <span class="text-primary font-bold">Checkout</span>
    </nav>

    <!-- Page Header -->
    <header class="mb-10">
        <h1 class="font-headline-lg text-2xl md:text-3xl text-primary font-extrabold tracking-tight">Checkout Pesanan</h1>
        <p class="text-on-surface-variant mt-2 text-sm">Lengkapi data di bawah ini untuk menyelesaikan pesanan Anda.</p>
    </header>

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">

        <!-- ── Left Column: Form Data ── -->
        <section class="w-full lg:w-2/3 bg-surface-container-lowest rounded-2xl p-6 md:p-8 soft-shadow border border-outline-variant/10 animate-on-scroll">

            <h2 class="font-headline-md text-lg text-primary font-bold mb-6 pb-4 border-b border-outline-variant/40 flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">person</span>
                Data Pemesanan
            </h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-semibold">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-semibold">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if ($errors = session()->getFlashdata('errors')): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="checkout-form" class="space-y-6" method="post" action="<?= base_url('/checkout/process') ?>">
    <?= csrf_field() ?>

                <!-- Step 1: Identitas -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="step-badge">1</div>
                        <h3 class="font-label-md text-sm font-bold text-on-surface uppercase tracking-widest">Identitas Pemesan</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Nama Pemesan *</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" required
                                   class="form-input" placeholder="Masukkan nama Anda"
                                   value="<?= old('nama_pemesan') ?>">
                        </div>
                        <div>
                            <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Nama Penerima</label>
                            <input type="text" id="nama_penerima" name="nama_penerima"
                                   class="form-input" placeholder="Nama penerima (opsional)"
                                   value="<?= old('nama_penerima') ?>">
                        </div>
                    </div>
                </div>

                <!-- Step 2: Kontak -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="step-badge">2</div>
                        <h3 class="font-label-md text-sm font-bold text-on-surface uppercase tracking-widest">Kontak</h3>
                    </div>
                    <div>
                        <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Nomor HP (WhatsApp) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm font-bold pointer-events-none select-none">+62</span>
                            <input type="tel" id="no_hp" name="no_hp" required
                                   class="form-input !pl-16" placeholder="81234567890"
                                   value="<?= esc($phoneDisplay) ?>">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Pengiriman -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="step-badge">3</div>
                        <h3 class="font-label-md text-sm font-bold text-on-surface uppercase tracking-widest">Pengiriman</h3>
                    </div>

                    <!-- Metode -->
                    <div class="mb-5">
                        <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-3 uppercase tracking-wide">Metode Pengambilan *</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="metode" value="ambil_toko" id="metode_toko"
                                       class="w-4 h-4 text-primary focus:ring-primary"
                                       onchange="toggleAlamat()"
                                       <?= old('metode') === '' || old('metode') === 'ambil_toko' ? 'checked' : '' ?>>
                                <div class="flex items-center gap-2 px-4 py-2.5 rounded-full border border-outline-variant group-has-[:checked]:border-primary group-has-[:checked]:bg-primary-container/20 transition-all text-sm font-semibold">
                                    <span class="material-symbols-outlined text-base">storefront</span> Ambil di Toko
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="metode" value="kurir" id="metode_kurir"
                                       class="w-4 h-4 text-primary focus:ring-primary"
                                       onchange="toggleAlamat()"
                                       <?= old('metode') === 'kurir' ? 'checked' : '' ?>>
                                <div class="flex items-center gap-2 px-4 py-2.5 rounded-full border border-outline-variant group-has-[:checked]:border-primary group-has-[:checked]:bg-primary-container/20 transition-all text-sm font-semibold">
                                    <span class="material-symbols-outlined text-base">local_shipping</span> Kirim via Kurir
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Alamat (muncul jika Kurir dipilih) -->
                    <div id="alamat-section" class="hidden mb-5">
                        <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Alamat Lengkap *</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="form-input resize-none" placeholder="Masukkan alamat lengkap pengiriman (kelurahan, kecamatan, kota)"><?= old('alamat') ?></textarea>
                    </div>

                    <!-- Tanggal & Jam -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Tanggal Pengiriman/Pengambilan *</label>
                            <input type="date" id="tanggal" name="tanggal" required class="form-input" value="<?= old('tanggal') ?>">
                            <p id="date-preview" class="text-xs text-on-surface-variant mt-1.5 font-medium"><?= old('tanggal') ? 'Tanggal dipilih: ' . date('d-m-Y', strtotime(old('tanggal'))) : 'Format tanggal: dd-mm-yyyy' ?></p>
                        </div>
                        <div>
                            <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Jam Pengiriman/Pengambilan *</label>
                            <input type="time" id="jam" name="jam" required class="form-input" value="<?= old('jam') ?>">
                        </div>
                    </div>
                </div>

                <!-- Step 4: Pesan & Catatan -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="step-badge">4</div>
                        <h3 class="font-label-md text-sm font-bold text-on-surface uppercase tracking-widest">Pesan & Catatan</h3>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Isi Kartu Ucapan</label>
                            <textarea id="kartu_ucapan" name="kartu_ucapan" rows="3"
                                      class="form-input resize-none" placeholder="Tuliskan pesan untuk kartu ucapan (opsional)"><?= old('kartu_ucapan') ?></textarea>
                        </div>
                        <div>
                            <label class="block font-label-md text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wide">Catatan Tambahan</label>
                            <textarea id="catatan" name="catatan" rows="2"
                                      class="form-input resize-none" placeholder="Catatan khusus lainnya (opsional)"><?= old('catatan') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit CTA -->
                <div class="pt-4 border-t border-outline-variant/30">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-3 rounded-full bg-primary text-white font-semibold px-5 py-4 min-h-[58px] shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300">
                        <span class="material-symbols-outlined text-[22px] shrink-0">chat</span>
                        <span class="block text-center leading-snug text-sm sm:text-base">
                            Konfirmasi & Hubungi via WhatsApp
                        </span>
                    </button>
                    <p class="text-center text-xs text-on-surface-variant mt-4 font-medium max-w-xs mx-auto">
                        Anda akan diarahkan ke WhatsApp untuk konfirmasi pesanan & pembayaran.
                    </p>
                </div>

            </form>
        </section>

        <!-- ── Right Column: Order Summary Sidebar ── -->
        <aside class="w-full lg:w-1/3 bg-primary-container/15 rounded-2xl p-6 soft-shadow sticky top-28 border border-primary-container/30 animate-on-scroll slide-in-right">
            <h2 class="font-headline-md text-lg text-primary font-bold mb-6 pb-4 border-b border-primary/20">Ringkasan Pesanan</h2>

            <!-- Product List -->
            <div class="space-y-4 mb-6">
                <?php foreach ($orderItems as $item): ?>
                <div class="flex gap-4 bg-surface-container-lowest p-4 rounded-xl border border-outline-variant/10 transition-all hover:shadow-sm">
                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-surface-container-low">
                        <img class="w-full h-full object-cover"
                             src="<?= esc($item['foto']) ?>"
                             onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'"
                             alt="<?= esc($item['nama']) ?>">
                    </div>
                    <div class="flex-grow min-w-0">
                        <span class="font-label-md text-[10px] font-extrabold text-primary uppercase tracking-widest"><?= esc($item['kategori']) ?></span>
                        <h4 class="font-bold text-sm text-on-surface line-clamp-1 mb-1"><?= esc($item['nama']) ?></h4>
                        <p class="text-xs text-on-surface-variant"><?= esc(formatVariantDisplay($item['ukuran'] ?? '', $item['warna'] ?? '')) ?></p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-on-surface-variant">x<?= $item['qty'] ?></span>
                            <span class="text-sm font-extrabold text-primary">Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Totals -->
            <div class="border-t border-primary/20 pt-4 mb-5 space-y-2">
                <div class="flex justify-between text-sm text-on-surface-variant">
                    <span>Total Produk (<?= $totalItems ?> item)</span>
                    <span class="font-semibold">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between text-sm text-on-surface-variant">
                    <span>Ongkos Kirim</span>
                    <span class="font-semibold text-on-surface">Dikonfirmasi via WA</span>
                </div>
                <div class="flex justify-between font-extrabold text-primary text-base pt-2 border-t border-primary/20 mt-2">
                    <span>Estimasi Subtotal</span>
                    <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>
            </div>

            <!-- Info Note -->
            <div class="bg-secondary-container/50 text-on-secondary-container p-4 rounded-xl flex gap-3 items-start mb-5">
                <span class="material-symbols-outlined text-primary text-lg mt-0.5 flex-shrink-0">info</span>
                <p class="text-xs leading-relaxed font-medium">Harga final (termasuk ongkir) akan dikonfirmasi melalui WhatsApp sesuai request custom Anda.</p>
            </div>

            <!-- Back to Cart -->
            <a href="<?= base_url('/keranjang') ?>"
               class="flex items-center justify-center gap-2 text-primary font-bold text-sm hover:underline group">
                <span class="material-symbols-outlined text-base group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Kembali ke Keranjang
            </a>
        </aside>
    </div>
</div>

<script>
(function () {
    'use strict';

    // Show/hide alamat field based on shipping method
    window.toggleAlamat = function () {
        const kurir  = document.getElementById('metode_kurir');
        const section = document.getElementById('alamat-section');
        const input   = document.getElementById('alamat');
        if (kurir && kurir.checked) {
            section.classList.remove('hidden');
            input.required = true;
        } else {
            section.classList.add('hidden');
            input.required = false;
        }
    };

    // Set min date to today
    const dateInput = document.getElementById('tanggal');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;
    }

    // Date format preview (dd-mm-yyyy)
    const previewEl = document.getElementById('date-preview');
    if (dateInput && previewEl) {
        dateInput.addEventListener('change', function () {
            if (this.value) {
                const parts = this.value.split('-');
                previewEl.textContent = 'Tanggal dipilih: ' + parts[2] + '-' + parts[1] + '-' + parts[0];
            } else {
                previewEl.textContent = 'Format tanggal: dd-mm-yyyy';
            }
        });
    }

    // Show alamat section on load if "Kirim via Kurir" was previously selected
    toggleAlamat();

})();
</script>

<?= $this->endSection() ?>
