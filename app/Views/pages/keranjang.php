<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$cartItems = $cartItems ?? [];
$subtotal = (int)($subtotal ?? 0);
$totalItems = (int)($totalItems ?? 0);
?>

<style>
    .soft-shadow { box-shadow: 0 4px 20px rgba(121,84,101,0.06); }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(121,84,101,0.10); }
</style>

<div class="w-full px-6 md:px-12 lg:px-16 mx-auto py-10 md:py-14">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl bg-primary-container/40 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-2xl">shopping_bag</span>
        </div>
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl text-primary font-extrabold tracking-tight">Keranjang Saya</h1>
            <p class="text-sm text-on-surface-variant font-medium mt-0.5"><?= (int)$totalItems ?> qty produk dalam keranjang</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-semibold flash-slide-down"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-semibold flash-slide-down"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="flex flex-col items-center justify-center py-24 text-center animate-on-scroll">
            <div class="w-24 h-24 rounded-full bg-primary-container/30 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-5xl text-primary/60">shopping_cart</span>
            </div>
            <h2 class="font-headline-md text-xl text-on-surface font-bold mb-2">Keranjang Masih Kosong</h2>
            <p class="text-on-surface-variant text-sm mb-8 max-w-sm">Yuk temukan buket & kado custom terbaik untuk momen spesialmu!</p>
            <a href="<?= base_url('/katalog') ?>" class="bg-primary text-on-primary px-8 py-3.5 rounded-full font-label-md text-sm font-bold hover:bg-on-primary-fixed-variant transition-all hover:scale-105 active:scale-95 inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">storefront</span> Jelajahi Katalog
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <div class="lg:col-span-8 flex flex-col gap-5 animate-on-scroll" data-stagger>
                <?php foreach ($cartItems as $item): ?>
                    <?php $itemKey = (string)($item['key'] ?? $item['id']); ?>
                    <article class="bg-surface-container-lowest rounded-2xl p-5 md:p-6 soft-shadow hover-lift card-hover border border-outline-variant/10">
                        <div class="flex flex-col sm:flex-row gap-5 items-start">
                            <a href="<?= base_url('/produk/' . esc($item['slug'] ?? '')) ?>" class="w-full sm:w-28 md:w-32 h-32 rounded-xl overflow-hidden flex-shrink-0 block group bg-surface-container-low">
                                <img alt="<?= esc($item['nama'] ?? '-') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= esc($item['foto'] ?? base_url('assets/images/no-image.svg')) ?>">
                            </a>

                            <div class="flex-grow w-full">
                                <div class="flex justify-between items-start gap-3 mb-3">
                                    <div>
                                        <span class="font-label-md text-[10px] font-extrabold text-primary uppercase tracking-widest block mb-1"><?= esc($item['kategori'] ?? '-') ?></span>
                                        <h3 class="font-headline-md text-base md:text-lg text-on-surface font-bold leading-snug"><?= esc($item['nama'] ?? '-') ?></h3>
                                        <p class="text-xs text-on-surface-variant mt-1">SKU: <?= esc($item['sku'] ?? '-') ?><?php
                                            $_varian = $item['ukuran'] ?? '-';
                                            if (!empty($_varian) && $_varian !== '-') {
                                                echo ' · Varian: ' . esc($_varian);
                                            }
                                        ?></p>
                                    </div>
                                    <form action="<?= base_url('/keranjang/remove') ?>" method="post" class="flex-shrink-0">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="key" value="<?= esc($itemKey) ?>">
                                        <button type="submit" aria-label="Hapus item" class="text-outline hover:text-error transition-colors p-2 rounded-full hover:bg-error-container active:scale-90">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>

                                <form action="<?= base_url('/keranjang/update') ?>" method="post" class="grid grid-cols-1 md:grid-cols-[150px_1fr_auto] gap-4 items-end">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="key" value="<?= esc($itemKey) ?>">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase">Qty</label>
                                        <input type="number" name="qty" min="1" value="<?= (int)($item['qty'] ?? 1) ?>" class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm font-bold">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase">Edit Catatan Custom / Warna / Tema</label>
                                        <textarea name="custom_notes" rows="3" class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm" placeholder="Ucapan kartu, warna wrapping, tema bucket, request bunga, catatan khusus lainnya"><?= esc($item['catatan'] ?? '') ?></textarea>
                                    </div>
                                    <button type="submit" class="rounded-full bg-primary text-on-primary px-5 py-3 font-bold text-sm hover:opacity-90 transition">Update</button>
                                </form>

                                <div class="flex justify-between items-center mt-4 pt-4 border-t border-outline-variant/20">
                                    <p class="text-xs text-on-surface-variant">Harga satuan: <strong>Rp <?= number_format((int)($item['harga'] ?? 0), 0, ',', '.') ?></strong></p>
                                    <p class="text-base md:text-lg font-extrabold text-primary">Rp <?= number_format((int)($item['harga'] ?? 0) * (int)($item['qty'] ?? 1), 0, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <div class="flex flex-wrap gap-3 mt-2">
                    <a href="<?= base_url('/katalog') ?>" class="inline-flex items-center gap-2 text-primary font-bold text-sm hover:underline group">
                        <span class="material-symbols-outlined text-base group-hover:-translate-x-1 transition-transform">arrow_back</span>
                        Lanjut Belanja
                    </a>
                    <form action="<?= base_url('/keranjang/clear') ?>" method="post" onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-error font-bold text-sm hover:underline">Kosongkan Keranjang</button>
                    </form>
                </div>
            </div>

            <aside class="lg:col-span-4 sticky top-28 animate-on-scroll">
                <div class="bg-primary-container/15 rounded-2xl p-6 border border-primary-container/40 soft-shadow">
                    <h2 class="font-headline-md text-lg text-on-surface font-bold mb-6 pb-4 border-b border-outline-variant/40">Ringkasan Pesanan</h2>
                    <div class="space-y-3 mb-6">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="flex justify-between text-sm text-on-surface-variant gap-3">
                                <span class="line-clamp-1 flex-1"><?= esc($item['nama'] ?? '-') ?> (x<?= (int)($item['qty'] ?? 1) ?>)</span>
                                <span class="font-semibold flex-shrink-0">Rp <?= number_format((int)($item['harga'] ?? 0) * (int)($item['qty'] ?? 1), 0, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-t border-outline-variant/40 pt-4 mb-6">
                        <div class="flex justify-between font-extrabold text-primary text-base md:text-lg">
                            <span>Subtotal Estimasi</span>
                            <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="bg-secondary-container/60 text-on-secondary-container p-4 rounded-xl mb-6 flex gap-3 items-start">
                        <span class="material-symbols-outlined text-primary text-lg mt-0.5 flex-shrink-0">info</span>
                        <p class="text-xs leading-relaxed font-medium">Harga final dan ongkir akan dikonfirmasi melalui WhatsApp sesuai request custom Anda.</p>
                    </div>
                    <a href="<?= base_url('/checkout') ?>" class="w-full bg-primary hover:bg-on-primary-fixed-variant text-on-primary font-label-md text-sm font-bold py-4 rounded-full transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        Lanjut ke Checkout
                    </a>
                </div>
            </aside>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
