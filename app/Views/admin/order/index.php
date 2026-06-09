<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6 admin-enter">

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

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest dark:bg-on-background rounded-2xl p-4 md:p-6 soft-shadow border border-outline-variant/20 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 card-hover-admin admin-enter">
        <form method="get" action="<?= base_url('admin/pesanan') ?>" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow max-w-4xl w-full">
            <div class="relative flex items-center flex-grow">
                <span class="material-symbols-outlined absolute left-4 text-on-surface-variant select-none">search</span>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari kode, nama, atau no HP..."
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest dark:bg-white/5 text-sm text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40">
            </div>
            <div class="flex flex-col sm:flex-row items-stretch gap-3">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="appearance-none pl-4 pr-10 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest dark:bg-[#211b1f] text-sm text-on-surface dark:text-white cursor-pointer min-w-[150px]">
                        <option value="">Semua Status</option>
                        <option value="baru" <?= ($selectedStatus ?? '') === 'baru' ? 'selected' : '' ?>>Baru</option>
                        <option value="diproses" <?= ($selectedStatus ?? '') === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="selesai" <?= ($selectedStatus ?? '') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="dibatalkan" <?= ($selectedStatus ?? '') === 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
                <input type="date" name="date_start" value="<?= esc($dateStart ?? '') ?>" onchange="this.form.submit()" title="Tanggal mulai" class="rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest dark:bg-[#211b1f] text-sm text-on-surface dark:text-white px-4 py-3">
                <input type="date" name="date_end" value="<?= esc($dateEnd ?? '') ?>" onchange="this.form.submit()" title="Tanggal akhir" class="rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest dark:bg-[#211b1f] text-sm text-on-surface dark:text-white px-4 py-3">
                <button type="submit" class="px-4 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 text-on-surface-variant dark:text-white/70 hover:bg-surface-container dark:hover:bg-white/10 transition-all text-sm font-semibold">
                    <span class="material-symbols-outlined text-lg align-middle">refresh</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Desktop Container -->
    <div class="hidden md:block bg-surface-container-lowest rounded-2xl border border-outline-variant/20 soft-shadow overflow-hidden card-hover-admin">
        <div class="p-6 border-b border-outline-variant/20 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-primary">Daftar Pesanan</h2>
                <p class="text-sm text-on-surface-variant mt-1">
                    Pesanan yang masuk dari checkout pelanggan.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <?php
                    // Build query string from current filters to preserve them in export links
                    $qs = [];
                    if (!empty($search)) $qs['search'] = $search;
                    if (!empty($selectedStatus)) $qs['status'] = $selectedStatus;
                    if (!empty($dateStart)) $qs['date_start'] = $dateStart;
                    if (!empty($dateEnd)) $qs['date_end'] = $dateEnd;
                    $queryString = !empty($qs) ? '?' . http_build_query($qs) : '';
                ?>
                <a href="<?= base_url('admin/pesanan/export-csv') . $queryString ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/50 text-sm font-semibold transition-colors soft-shadow border border-green-200 dark:border-green-800">
                    <span class="material-symbols-outlined text-[18px]">table</span>
                    Export CSV
                </a>
                <a href="<?= base_url('admin/pesanan/print') . $queryString ?>" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-sm font-semibold transition-colors soft-shadow border border-blue-200 dark:border-blue-800">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    Print / PDF
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-surface-container-low dark:bg-[#2a2328]">
                    <tr class="text-left text-on-surface-variant dark:text-white/70">
                        <th class="px-6 py-4 font-bold">Kode</th>
                        <th class="px-6 py-4 font-bold">Nama</th>
                        <th class="px-6 py-4 font-bold">No HP</th>
                        <th class="px-6 py-4 font-bold">Metode</th>
                        <th class="px-6 py-4 font-bold">Total</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-primary">
                                    <?= esc($order['order_code']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= esc($order['customer_name']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= esc($order['phone']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                    $__methodLabel = [
                                        'ambil_toko' => 'Ambil di Toko',
                                        'kurir'      => 'Kirim via Kurir',
                                    ][$order['delivery_method']] ?? $order['delivery_method'];
                                    ?>
                                    <?= esc($__methodLabel) ?>
                                </td>
                                <td class="px-6 py-4 font-bold">
                                    Rp <?= number_format((int) $order['subtotal'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                        $statusClass = [
                                            'baru'       => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                            'diproses'   => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
                                            'selesai'    => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                                            'dibatalkan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                        ][$order['status']] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300';
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold <?= $statusClass ?>">
                                        <?= esc(ucfirst($order['status'])) ?>
                                    </span>
                                </td>
                    <td class="px-6 py-4 text-on-surface-variant dark:text-white/60">
                    <?= formatDatetimeIndo($order['created_at']) ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>"
                                       class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-primary text-on-primary text-xs font-bold hover:opacity-90 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (!empty($orders) && isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="p-6 border-t border-outline-variant/20 flex justify-center">
            <?= $pager->links('admin_pagination', 'admin_pagination') ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Mobile Card Layout -->
    <div class="md:hidden space-y-4">
        <div class="flex gap-2">
            <a href="<?= base_url('admin/pesanan/export-csv') . (!empty($qs) ? '?' . http_build_query($qs) : '') ?>" class="flex-1 inline-flex justify-center items-center gap-1.5 px-4 py-2 rounded-xl bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 text-sm font-semibold border border-green-200 dark:border-green-800 soft-shadow">
                <span class="material-symbols-outlined text-[18px]">table</span> CSV
            </a>
            <a href="<?= base_url('admin/pesanan/print') . (!empty($qs) ? '?' . http_build_query($qs) : '') ?>" target="_blank" class="flex-1 inline-flex justify-center items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-sm font-semibold border border-blue-200 dark:border-blue-800 soft-shadow">
                <span class="material-symbols-outlined text-[18px]">print</span> Print
            </a>
        </div>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <?php
                    $statusClass = [
                        'baru'       => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                        'diproses'   => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
                        'selesai'    => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-800',
                        'dibatalkan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-200 dark:border-red-800',
                    ][$order['status']] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700';
                    
                    $__methodLabel = [
                        'ambil_toko' => 'Ambil di Toko',
                        'kurir'      => 'Kirim via Kurir',
                    ][$order['delivery_method']] ?? $order['delivery_method'];
                ?>
                <div class="bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/20 soft-shadow flex flex-col gap-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="block text-primary font-bold text-lg leading-none mb-1.5"><?= esc($order['order_code']) ?></span>
                            <span class="text-[11px] text-on-surface-variant"><?= formatDatetimeIndo($order['created_at']) ?></span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $statusClass ?>">
                            <?= esc(ucfirst($order['status'])) ?>
                        </span>
                    </div>
                    
                    <div class="border-t border-b border-outline-variant/10 py-3 flex flex-col gap-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">Pelanggan</span>
                            <span class="font-semibold text-on-surface text-right truncate max-w-[160px]"><?= esc($order['customer_name']) ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">No HP</span>
                            <span class="font-semibold text-on-surface"><?= esc($order['phone']) ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">Metode</span>
                            <span class="font-semibold text-on-surface"><?= esc($__methodLabel) ?></span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-on-surface-variant">Total</span>
                            <span class="font-bold text-primary dark:text-primary-fixed-dim">Rp <?= number_format((int) $order['subtotal'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    
                    <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>"
                       class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-xl bg-primary/10 text-primary hover:bg-primary/20 text-sm font-bold transition-colors">
                        <span class="material-symbols-outlined text-[18px]">visibility</span> Lihat Detail
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-surface-container-lowest rounded-2xl p-8 text-center border border-outline-variant/20 soft-shadow">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-3 block">receipt_long</span>
                <h3 class="text-sm font-bold text-on-surface">Belum ada pesanan</h3>
                <p class="text-xs text-on-surface-variant mt-1 mb-4">Pesanan dari checkout pelanggan akan tampil di sini.</p>
            </div>
        <?php endif; ?>
        <?php if (!empty($orders) && isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="flex justify-center pt-4">
            <?= $pager->links('admin_pagination', 'admin_pagination') ?>
        </div>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>