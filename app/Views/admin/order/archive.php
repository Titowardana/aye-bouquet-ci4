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

    <!-- Back link -->
    <div>
        <a href="<?= base_url('admin/pesanan') ?>"
           class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:underline">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Pesanan Aktif
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-6 soft-shadow border border-outline-variant/20 dark:border-white/10 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 card-hover-admin admin-enter">
        <form method="get" action="<?= base_url('admin/pesanan/arsip') ?>" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-grow max-w-4xl w-full">
            <div class="relative flex items-center flex-grow">
                <span class="material-symbols-outlined absolute left-4 text-on-surface-variant select-none">search</span>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari kode, nama, atau no HP..."
                       class="admin-filter-input w-full pl-12 pr-4 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40">
            </div>
            <div class="flex flex-col sm:flex-row items-stretch gap-3">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="admin-filter-select w-full pl-4 pr-10 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white cursor-pointer min-w-[150px]">
                        <option value="">Semua Status</option>
                        <option value="baru" <?= ($selectedStatus ?? '') === 'baru' ? 'selected' : '' ?>>Baru</option>
                        <option value="diproses" <?= ($selectedStatus ?? '') === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="selesai" <?= ($selectedStatus ?? '') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="dibatalkan" <?= ($selectedStatus ?? '') === 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                </div>
                <input type="date" name="date_start" value="<?= esc($dateStart ?? '') ?>" onchange="this.form.submit()" title="Tanggal mulai" class="admin-filter-date rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white px-4 py-3">
                <input type="date" name="date_end" value="<?= esc($dateEnd ?? '') ?>" onchange="this.form.submit()" title="Tanggal akhir" class="admin-filter-date rounded-xl border border-outline-variant/60 dark:border-white/15 bg-surface-container-lowest text-sm text-on-surface dark:text-white px-4 py-3">
                <button type="submit" class="px-4 py-3 rounded-xl border border-outline-variant/60 dark:border-white/15 text-on-surface-variant dark:text-white/70 hover:bg-surface-container dark:hover:bg-white/10 transition-all text-sm font-semibold">
                    <span class="material-symbols-outlined text-lg align-middle">refresh</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Bulk Action Bar (hidden by default) -->
    <div id="bulkBar" class="hidden bg-primary-container/30 dark:bg-primary-fixed-dim/10 rounded-2xl px-5 py-4 flex items-center justify-between border border-primary/20 soft-shadow">
        <span class="text-sm font-bold text-primary">
            <span id="selectedCount">0</span> pesanan dipilih
        </span>
        <div class="flex gap-2">
            <button type="button" id="bulkRestoreBtn"
                    onclick="confirmBulkRestore()"
                    class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-primary text-on-primary text-sm font-bold hover:opacity-90 transition shadow-sm cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">unarchive</span>
                Pulihkan Terpilih
            </button>
            <button type="button" id="bulkDeleteBtn"
                    onclick="confirmBulkDelete()"
                    class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-error text-on-error text-sm font-bold hover:opacity-90 transition shadow-sm cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                Hapus Permanen Terpilih
            </button>
        </div>
    </div>

    <!-- Bulk Form wraps both desktop table and mobile cards -->
    <form id="bulkForm" method="post" action="">
        <?= csrf_field() ?>

    <!-- Desktop Container -->
    <div class="hidden md:block bg-surface-container-lowest rounded-2xl border border-outline-variant/20 soft-shadow overflow-hidden card-hover-admin">
        <div class="p-6 border-b border-outline-variant/20 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-primary">Arsip Pesanan</h2>
                <p class="text-sm text-on-surface-variant mt-1">
                    Pesanan yang telah diarsipkan. Anda dapat memulihkan atau menghapus permanen.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-surface-container-low dark:bg-[#2a2328]">
                    <tr class="text-left text-on-surface-variant dark:text-white/70">
                        <th class="px-4 py-4 w-12">
                            <input type="checkbox" id="selectAll" onchange="toggleAll(this)"
                                   class="rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">
                        </th>
                        <th class="px-6 py-4 font-bold">Kode</th>
                        <th class="px-6 py-4 font-bold">Nama</th>
                        <th class="px-6 py-4 font-bold">No HP</th>
                        <th class="px-6 py-4 font-bold">Metode</th>
                        <th class="px-6 py-4 font-bold">Total</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Waktu Arsip</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-4 py-4">
                                    <input type="checkbox" name="order_ids[]" value="<?= $order['id'] ?>"
                                           class="row-checkbox rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">
                                </td>
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
                                    <?= formatDatetimeIndo($order['archived_at']) ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>"
                                           class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-primary text-on-primary text-xs font-bold hover:opacity-90 transition">
                                            Detail
                                        </a>
                                        <button type="button"
                                                onclick="openAdminConfirm({ title: 'Pulihkan Pesanan', message: 'Yakin ingin memulihkan pesanan <?= esc($order['order_code']) ?>?', confirmText: 'Ya, Pulihkan', confirmClass: 'bg-primary text-on-primary hover:bg-primary/90', action: '<?= base_url('admin/pesanan/pulihkan/' . $order['id']) ?>' })"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-full bg-surface-container-high text-on-surface-variant hover:bg-surface-container dark:bg-white/10 dark:text-white/70 dark:hover:bg-white/20 text-xs font-bold transition cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">unarchive</span>
                                        </button>
                                        <button type="button"
                                                onclick="openAdminConfirm({ title: 'Hapus Permanen', message: 'Yakin ingin menghapus permanen pesanan <?= esc($order['order_code']) ?>? Tindakan ini tidak dapat dibatalkan.', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', accentClass: 'absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-error via-error to-error/50', action: '<?= base_url('admin/pesanan/hapus-permanen/' . $order['id']) ?>' })"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-full bg-error/10 text-error hover:bg-error/20 text-xs font-bold transition cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">delete_forever</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-on-surface-variant">
                                Tidak ada pesanan di arsip.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (!empty($orders) && isset($pager) && $pager->getPageCount('admin_pagination') > 1): ?>
        <div class="p-6 border-t border-outline-variant/20 flex justify-center">
            <?= $pager->links('admin_pagination', 'admin_pagination') ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Mobile Card Layout -->
    <div class="md:hidden space-y-4">

        <!-- Mobile bulk bar -->
        <div id="mobileBulkBar" class="hidden bg-primary-container/30 dark:bg-primary-fixed-dim/10 rounded-2xl px-4 py-3 flex items-center justify-between border border-primary/20 soft-shadow">
            <span class="text-sm font-bold text-primary">
                <span id="mobileSelectedCount">0</span> dipilih
            </span>
            <div class="flex gap-2">
                <button type="button" onclick="confirmBulkRestore()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-primary text-on-primary text-xs font-bold hover:opacity-90 transition cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">unarchive</span>
                    Pulihkan
                </button>
                <button type="button" onclick="confirmBulkDelete()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-error text-on-error text-xs font-bold hover:opacity-90 transition cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">delete_forever</span>
                    Hapus
                </button>
            </div>
        </div>

        <!-- Mobile select all -->
        <div class="flex items-center gap-3 px-1 <?= empty($orders) ? 'hidden' : '' ?>">
            <input type="checkbox" id="mobileSelectAll" onchange="toggleAll(this)"
                   class="rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">
            <label for="mobileSelectAll" class="text-xs font-semibold text-on-surface-variant cursor-pointer select-none">Pilih semua</label>
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
                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="order_ids[]" value="<?= $order['id'] ?>"
                                   class="row-checkbox mt-1 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">
                            <div>
                                <span class="block text-primary font-bold text-lg leading-none mb-1.5"><?= esc($order['order_code']) ?></span>
                                <span class="text-[11px] text-on-surface-variant">Diarsipkan: <?= formatDatetimeIndo($order['archived_at']) ?></span>
                            </div>
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

                    <div class="flex gap-2">
                        <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-xl bg-primary/10 text-primary hover:bg-primary/20 text-sm font-bold transition-colors">
                            <span class="material-symbols-outlined text-[18px]">visibility</span> Detail
                        </a>
                        <button type="button"
                                onclick="openAdminConfirm({ title: 'Pulihkan Pesanan', message: 'Yakin ingin memulihkan pesanan <?= esc($order['order_code']) ?>?', confirmText: 'Ya, Pulihkan', confirmClass: 'bg-primary text-on-primary hover:bg-primary/90', action: '<?= base_url('admin/pesanan/pulihkan/' . $order['id']) ?>' })"
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-xl bg-surface-container-high text-on-surface-variant hover:bg-surface-container dark:bg-white/10 dark:text-white/70 dark:hover:bg-white/20 text-sm font-bold transition cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">unarchive</span>
                        </button>
                        <button type="button"
                                onclick="openAdminConfirm({ title: 'Hapus Permanen', message: 'Yakin ingin menghapus permanen pesanan <?= esc($order['order_code']) ?>? Tindakan ini tidak dapat dibatalkan.', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', accentClass: 'absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-error via-error to-error/50', action: '<?= base_url('admin/pesanan/hapus-permanen/' . $order['id']) ?>' })"
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-xl bg-error/10 text-error hover:bg-error/20 text-sm font-bold transition cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-surface-container-lowest rounded-2xl p-8 text-center border border-outline-variant/20 soft-shadow">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-3 block">archive</span>
                <h3 class="text-sm font-bold text-on-surface">Arsip kosong</h3>
                <p class="text-xs text-on-surface-variant mt-1 mb-4">Belum ada pesanan yang diarsipkan.</p>
                <a href="<?= base_url('admin/pesanan') ?>" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-primary text-on-primary text-sm font-bold hover:opacity-90 transition">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Pesanan Aktif
                </a>
            </div>
        <?php endif; ?>
        <?php if (!empty($orders) && isset($pager) && $pager->getPageCount('admin_pagination') > 1): ?>
        <div class="flex justify-center pt-4">
            <?= $pager->links('admin_pagination', 'admin_pagination') ?>
        </div>
        <?php endif; ?>
    </div>

    </form><!-- /bulkForm -->

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateBulkSelection();
    document.querySelectorAll('.row-checkbox').forEach(function(cb) {
        cb.addEventListener('change', function() {
            updateBulkSelection();
            syncSelectAll();
        });
    });
    document.querySelectorAll('#selectAll, #mobileSelectAll').forEach(function(el) {
        el.addEventListener('change', function() {
            toggleAll(this);
        });
    });
});

function updateBulkSelection() {
    var checked = document.querySelectorAll('.row-checkbox:checked');
    var count = checked.length;
    var desktopBar = document.getElementById('bulkBar');
    var mobileBar = document.getElementById('mobileBulkBar');
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('mobileSelectedCount').textContent = count;
    if (count > 0) {
        desktopBar.classList.remove('hidden');
        mobileBar.classList.remove('hidden');
    } else {
        desktopBar.classList.add('hidden');
        mobileBar.classList.add('hidden');
    }
}

function syncSelectAll() {
    var all = document.querySelectorAll('.row-checkbox');
    var checked = document.querySelectorAll('.row-checkbox:checked');
    var desktopSa = document.getElementById('selectAll');
    var mobileSa = document.getElementById('mobileSelectAll');
    var allChecked = all.length === checked.length;
    if (desktopSa) { desktopSa.checked = allChecked; desktopSa.indeterminate = checked.length > 0 && !allChecked; }
    if (mobileSa) { mobileSa.checked = allChecked; mobileSa.indeterminate = checked.length > 0 && !allChecked; }
}

function toggleAll(source) {
    document.querySelectorAll('.row-checkbox').forEach(function(cb) {
        cb.checked = source.checked;
    });
    updateBulkSelection();
}

function confirmBulkRestore() {
    var checked = document.querySelectorAll('.row-checkbox:checked');
    if (checked.length === 0) return;
    openAdminConfirm({
        title: 'Pulihkan Pesanan Terpilih',
        message: 'Yakin ingin memulihkan ' + checked.length + ' pesanan terpilih? Pesanan akan kembali ke daftar aktif.',
        confirmText: 'Ya, Pulihkan',
        confirmClass: 'bg-primary text-on-primary hover:bg-primary/90',
        onConfirm: function() {
            var form = document.getElementById('bulkForm');
            form.action = '<?= base_url('admin/pesanan/arsip/bulk-restore') ?>';
            form.submit();
        }
    });
}

function confirmBulkDelete() {
    var checked = document.querySelectorAll('.row-checkbox:checked');
    if (checked.length === 0) return;
    openAdminConfirm({
        title: 'Hapus Permanen Terpilih',
        message: 'Yakin ingin menghapus permanen ' + checked.length + ' pesanan terpilih? Data akan dihapus permanen dan tidak bisa dikembalikan.',
        confirmText: 'Ya, Hapus',
        confirmClass: 'bg-error text-on-error hover:bg-error/90',
        accentClass: 'absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-error via-error to-error/50',
        onConfirm: function() {
            var form = document.getElementById('bulkForm');
            form.action = '<?= base_url('admin/pesanan/arsip/bulk-delete') ?>';
            form.submit();
        }
    });
}
</script>
<?= $this->endSection() ?>
