<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6 admin-enter">

    <?php
    $methodLabel = [
        'ambil_toko' => 'Ambil di Toko',
        'kurir'      => 'Kirim via Kurir',
    ][$order['delivery_method']] ?? $order['delivery_method'];
    ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700/30 text-green-700 dark:text-green-300 px-5 py-4 text-sm font-semibold">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/30 text-red-700 dark:text-red-300 px-5 py-4 text-sm font-semibold">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="flex items-center justify-between gap-4">
        <a href="<?= base_url($order['is_archived'] ? 'admin/pesanan/arsip' : 'admin/pesanan') ?>"
           class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:underline">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke <?= $order['is_archived'] ? 'Arsip' : 'Daftar Pesanan' ?>
        </a>
        <?php if ($order['is_archived']): ?>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container-high text-on-surface-variant dark:bg-white/10 dark:text-white/70 text-xs font-bold">
                <span class="material-symbols-outlined text-[14px]">archive</span>
                Diarsipkan
            </span>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <!-- Order Info Card -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 soft-shadow p-5 md:p-6 card-hover-admin admin-enter admin-enter-delay-1">
                <div class="flex items-start justify-between mb-4 gap-3">
                    <h2 class="text-lg md:text-xl font-bold text-primary leading-tight">
                        <?= esc($order['order_code']) ?>
                    </h2>
                    <?php
                        $statusClass = [
                            'baru'       => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                            'diproses'   => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
                            'selesai'    => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                            'dibatalkan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                        ][$order['status']] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300';
                    ?>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold flex-shrink-0 <?= $statusClass ?>">
                        <?= esc(ucfirst($order['status'])) ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">Nama Pemesan</p>
                        <p class="font-bold"><?= esc($order['customer_name']) ?></p>
                    </div>

                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">Nama Penerima</p>
                        <p class="font-bold"><?= esc($order['recipient_name'] ?: '-') ?></p>
                    </div>

                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">No HP</p>
                        <p class="font-bold"><?= esc($order['phone']) ?></p>
                    </div>

                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">Waktu Pesanan</p>
                        <p class="font-bold"><?= esc(formatDatetimeIndo($order['created_at'])) ?></p>
                    </div>

                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">Metode Pengiriman</p>
                        <p class="font-bold"><?= esc($methodLabel) ?></p>
                    </div>

                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">Tanggal Kirim</p>
                        <p class="font-bold"><?= esc(formatTanggalIndo($order['delivery_date'])) ?></p>
                    </div>

                    <div>
                        <p class="text-on-surface-variant text-xs mb-0.5">Jam Pengiriman</p>
                        <p class="font-bold"><?= esc(formatJamIndo($order['delivery_time'])) ?></p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-on-surface-variant text-xs mb-0.5">Alamat</p>
                        <p class="font-bold"><?= esc($order['address'] ?: '-') ?></p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-on-surface-variant text-xs mb-0.5">Kartu Ucapan</p>
                        <p class="font-bold whitespace-pre-line"><?= esc($order['greeting_card'] ?: '-') ?></p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-on-surface-variant text-xs mb-0.5">Catatan Tambahan</p>
                        <p class="font-bold whitespace-pre-line"><?= esc($order['notes'] ?: '-') ?></p>
                    </div>
                </div>
            </div>

            <!-- Items Ordered -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 soft-shadow overflow-hidden card-hover-admin admin-enter admin-enter-delay-2">
                <div class="p-5 md:p-6 border-b border-outline-variant/20">
                    <h3 class="text-base md:text-lg font-bold text-primary">Produk Dipesan</h3>
                </div>

                <!-- Desktop table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-surface-container-low dark:bg-[#2a2328]">
                            <tr class="text-left text-on-surface-variant dark:text-white/70">
                                <th class="px-6 py-4 font-bold">Produk</th>
                                <th class="px-6 py-4 font-bold">Varian</th>
                                <th class="px-6 py-4 font-bold">Qty</th>
                                <th class="px-6 py-4 font-bold">Harga</th>
                                <th class="px-6 py-4 font-bold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20">
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="font-bold"><?= esc($item['product_name']) ?></p>
                                        <p class="text-xs text-on-surface-variant"><?= esc($item['category_name'] ?: '-') ?> · SKU: <?= esc($item['sku'] ?? '-') ?></p>
                                        <?php if (!empty($item['product_url'])): ?>
                                            <a href="<?= esc($item['product_url']) ?>" target="_blank" class="text-xs text-primary hover:underline">Lihat produk</a>
                                        <?php endif; ?>
                                        <?php if (!empty($item['custom_note'])): ?>
                                            <p class="text-xs mt-2 text-primary">Catatan: <?= esc($item['custom_note']) ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4"><?= esc($item['variant_name'] ?: '-') ?></td>
                                    <td class="px-6 py-4"><?= esc($item['qty']) ?></td>
                                    <td class="px-6 py-4">
                                        Rp <?= number_format((int) $item['price'], 0, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-4 font-bold">
                                        Rp <?= number_format((int) $item['subtotal'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile cards for order items -->
                <div class="md:hidden divide-y divide-outline-variant/10">
                    <?php foreach ($items as $item): ?>
                        <div class="p-4 flex flex-col gap-2">
                            <div class="flex justify-between items-start gap-2">
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-sm text-on-surface leading-snug"><?= esc($item['product_name']) ?></p>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5"><?= esc($item['category_name'] ?: '-') ?> · SKU: <?= esc($item['sku'] ?? '-') ?></p>
                                    <?php if (!empty($item['product_url'])): ?>
                                        <a href="<?= esc($item['product_url']) ?>" target="_blank" class="text-[11px] text-primary hover:underline">Lihat produk</a>
                                    <?php endif; ?>
                                    <?php if (!empty($item['custom_note'])): ?>
                                        <p class="text-[11px] mt-1 text-primary">Catatan: <?= esc($item['custom_note']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <span class="text-sm font-extrabold text-primary flex-shrink-0">
                                    Rp <?= number_format((int) $item['subtotal'], 0, ',', '.') ?>
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-on-surface-variant">
                                <span>Varian: <strong class="text-on-surface"><?= esc($item['variant_name'] ?: '-') ?></strong></span>
                                <span>Qty: <strong class="text-on-surface"><?= esc($item['qty']) ?></strong></span>
                                <span>@ Rp <?= number_format((int) $item['price'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="space-y-6">
            <!-- Update Status -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 soft-shadow p-5 md:p-6 card-hover-admin admin-enter admin-enter-delay-3">
                <h3 class="text-base md:text-lg font-bold text-primary mb-4">Update Status Pesanan</h3>

                <form method="post" action="<?= base_url('admin/pesanan/update-status/' . $order['id']) ?>" class="space-y-4">
                    <?= csrf_field() ?>

                    <div class="relative">
                        <select name="status" class="w-full appearance-none rounded-xl border border-outline-variant dark:border-white/15 py-3 pl-4 pr-10 text-sm bg-surface dark:bg-surface-container text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none cursor-pointer">
                            <?php foreach (['baru', 'diproses', 'selesai', 'dibatalkan'] as $status): ?>
                                <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>>
                                    <?= ucfirst($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>

                    <button type="submit"
                            class="w-full rounded-full bg-primary text-on-primary py-3 font-bold text-sm hover:opacity-90 transition">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Total Estimasi -->
            <div class="bg-primary-container/20 rounded-2xl border border-primary-container p-5 md:p-6 card-hover-admin">
                <p class="text-sm text-on-surface-variant">Total Estimasi</p>
                <p class="text-2xl font-extrabold text-primary mt-1">
                    Rp <?= number_format((int) $order['subtotal'], 0, ',', '.') ?>
                </p>
                <p class="text-xs text-on-surface-variant mt-2">
                    Pembayaran tetap dikonfirmasi melalui WhatsApp.
                </p>
            </div>
        </aside>

    </div>
</div>

<?= $this->endSection() ?>