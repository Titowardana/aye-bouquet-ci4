<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .glass-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }
    .dark .glass-card {
        background: #2a2328;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .glow-shadow {
        box-shadow: 0 10px 30px -10px rgba(240, 113, 103, 0.2);
    }

    /* Dropdown options dark mode */
    .dark select option {
        background-color: #2b2027;
        color: #e5e7eb;
    }
    .dark select option:checked {
        background-color: #795465;
        color: #ffffff;
    }
</style>

<div class="max-w-[1280px] mx-auto p-4 md:p-6 space-y-6">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/30 dark:text-green-400" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-outline-variant/10">
        <div>
            <h2 class="font-headline-lg text-3xl font-bold text-on-surface">Opsi Custom Order</h2>
            <p class="text-body-md text-on-surface-variant max-w-2xl mt-1">Kelola pilihan ukuran, warna/tema, dan tambahan untuk form custom order pelanggan.</p>
        </div>
        <button type="button" onclick="openAddModal()" class="flex items-center gap-2 bg-primary-container text-on-primary-container px-4 py-2 rounded-lg font-label-lg hover:brightness-110 active:scale-95 transition-all glow-shadow shadow-md">
            <span class="material-symbols-outlined">add</span>
            Tambah Opsi
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card p-4 rounded-xl">
            <p class="text-on-surface-variant text-sm font-semibold tracking-wide">Total Opsi</p>
            <div class="flex items-end gap-2 mt-1">
                <span class="text-3xl font-bold text-on-surface"><?= esc($stats['total']) ?></span>
            </div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <p class="text-on-surface-variant text-sm font-semibold tracking-wide">Opsi Aktif</p>
            <div class="flex items-end gap-2 mt-1">
                <span class="text-3xl font-bold text-primary"><?= esc($stats['active']) ?></span>
            </div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <p class="text-on-surface-variant text-sm font-semibold tracking-wide">Add-on Berbayar</p>
            <div class="flex items-end gap-2 mt-1">
                <span class="text-3xl font-bold text-on-surface"><?= esc($stats['paidAddons']) ?></span>
            </div>
        </div>
        <div class="glass-card p-4 rounded-xl border-l-4 border-error/50">
            <p class="text-on-surface-variant text-sm font-semibold tracking-wide">Nonaktif</p>
            <div class="flex items-end gap-2 mt-1">
                <span class="text-3xl font-bold text-on-surface-variant"><?= esc($stats['inactive']) ?></span>
            </div>
        </div>
    </div>

    <!-- Action Bar & Filter -->
    <form method="GET" action="<?= base_url('admin/custom-options') ?>" class="flex flex-col md:flex-row gap-4 items-center justify-between glass-card p-3 rounded-xl">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Search -->
            <div class="relative flex-grow md:flex-grow-0">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Cari opsi custom..." class="w-full bg-surface rounded-lg py-2 pl-9 pr-3 focus:ring-1 focus:ring-primary-container outline-none text-sm text-on-surface dark:text-white/90 dark:placeholder:text-white/50 border border-outline-variant/20 dark:border-white/15">
            </div>
            
            <!-- Type Filter -->
            <select name="type" onchange="this.form.submit()" class="bg-surface border border-outline-variant/20 dark:border-white/15 rounded-lg py-2 px-3 text-sm focus:ring-1 focus:ring-primary-container outline-none text-on-surface-variant dark:text-white/90 hover:text-on-surface dark:hover:text-white cursor-pointer">
                <option value="">Semua Type</option>
                <option value="size" <?= $typeFilter === 'size' ? 'selected' : '' ?>>Size</option>
                <option value="color" <?= $typeFilter === 'color' ? 'selected' : '' ?>>Color</option>
                <option value="addon" <?= $typeFilter === 'addon' ? 'selected' : '' ?>>Add-on</option>
            </select>
            
            <!-- Status Filter -->
            <select name="status" onchange="this.form.submit()" class="bg-surface border border-outline-variant/20 dark:border-white/15 rounded-lg py-2 px-3 text-sm focus:ring-1 focus:ring-primary-container outline-none text-on-surface-variant dark:text-white/90 hover:text-on-surface dark:hover:text-white cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif" <?= $statusFilter === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $statusFilter === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
            
            <?php if(!empty($search) || !empty($typeFilter) || !empty($statusFilter)): ?>
                <a href="<?= base_url('admin/custom-options') ?>" class="text-xs text-error hover:underline">Reset</a>
            <?php endif; ?>
        </div>
        <p class="text-xs text-on-surface-variant w-full md:w-auto text-left md:text-right">
            <?php if (isset($pager)): ?>
                <?php $totalItems = $pager->getTotal('admin_pagination'); $curPage = $pager->getCurrentPage('admin_pagination'); $pageCount = $pager->getPageCount('admin_pagination'); ?>
                Menampilkan <?= count($options) ?> dari total <?= $totalItems ?> opsi
                <?php if ($pageCount > 1): ?>
                    — Halaman <?= $curPage ?> dari <?= $pageCount ?>
                <?php endif; ?>
            <?php else: ?>
                Menampilkan <?= count($options) ?> opsi
            <?php endif; ?>
        </p>
    </form>

    <!-- Desktop Table -->
    <div class="hidden md:block glass-card rounded-xl overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-surface-container-high dark:bg-white/5 border-b border-outline-variant/20 dark:border-white/10">
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Type</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Nama Opsi</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Harga Tambahan</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider text-center">Urutan</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider text-center">Status</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                <?php if (empty($options)): ?>
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-on-surface-variant">
                        <?php if (!empty($search) || !empty($typeFilter) || !empty($statusFilter)): ?>
                            Tidak ada opsi yang cocok dengan filter.
                        <?php else: ?>
                            Belum ada data opsi custom.
                        <?php endif; ?>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach($options as $opt): ?>
                        <?php 
                            $typeClass = '';
                            $typeLabel = strtoupper($opt['type']);
                            if ($opt['type'] === 'size') {
                                $typeClass = 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-500/20';
                            } elseif ($opt['type'] === 'color') {
                                $typeClass = 'bg-pink-100 text-pink-700 border-pink-200 dark:bg-pink-900/30 dark:text-pink-300 dark:border-pink-500/20';
                            } elseif ($opt['type'] === 'addon') {
                                $typeClass = 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-500/20';
                            }
                        ?>
                    <tr class="bg-white dark:bg-transparent hover:bg-pink-50 dark:hover:bg-[#2b2027] transition-colors group text-on-surface dark:text-gray-100">
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold border <?= $typeClass ?>"><?= $typeLabel ?></span>
                        </td>
                        <td class="px-4 py-3 font-medium text-sm"><?= esc($opt['name']) ?></td>
                        <td class="px-4 py-3 text-sm <?= $opt['additional_price'] > 0 ? 'text-primary dark:text-primary-fixed-dim font-medium' : 'text-on-surface-variant dark:text-gray-400' ?>">
                            Rp <?= number_format($opt['additional_price'], 0, ',', '.') ?>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-on-surface-variant dark:text-gray-400"><?= esc($opt['sort_order']) ?></td>
                        <td class="px-4 py-3 text-center">
                            <?php if ($opt['is_active']): ?>
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500/20 text-[10px] font-bold">AKTIF</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded-full bg-surface-variant/50 text-on-surface-variant dark:text-gray-400 text-[10px] font-bold border border-outline-variant/30">NONAKTIF</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2 opacity-100 md:opacity-60 group-hover:opacity-100 transition-opacity">
                                <form action="<?= base_url('admin/custom-options/toggle-status/' . $opt['id']) ?>" method="POST" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="p-1 hover:text-tertiary transition-colors" title="<?= $opt['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                        <span class="material-symbols-outlined text-xl"><?= $opt['is_active'] ? 'visibility_off' : 'visibility' ?></span>
                                    </button>
                                </form>
                                <button type="button" onclick='openEditModal(<?= json_encode($opt) ?>)' class="p-1 text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-primary-fixed-dim transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </button>
                                <button type="button" onclick="openAdminConfirm({ 
                                    title: 'Hapus Opsi?', 
                                    message: 'Opsi \'<?= esc(addslashes($opt['name'])) ?>\' akan dihapus permanen.', 
                                    icon: 'delete', 
                                    confirmText: 'Hapus', 
                                    confirmClass: 'bg-error text-on-error hover:bg-error/90', 
                                    action: '<?= base_url('admin/custom-options/delete/' . $opt['id']) ?>', 
                                    method: 'POST' 
                                })" class="p-1 text-on-surface-variant dark:text-gray-400 hover:text-error transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (!empty($options) && isset($pager) && $pager->getPageCount('admin_pagination') > 1): ?>
        <div class="p-4 border-t border-outline-variant/20 dark:border-white/10 flex justify-center bg-surface-container-low dark:bg-white/[0.03] rounded-b-xl">
            <?= $pager->links('admin_pagination', 'admin_pagination') ?>
        </div>
        <?php elseif (!empty($options) && isset($pager)): ?>
        <div class="p-3 border-t border-outline-variant/20 dark:border-white/10 flex justify-center bg-surface-container-low dark:bg-white/[0.03] rounded-b-xl">
            <span class="text-xs text-on-surface-variant dark:text-gray-400">Halaman 1 dari 1</span>
        </div>
        <?php endif; ?>
    </div>

    <!-- Mobile Card Layout -->
    <div class="md:hidden space-y-4">
        <?php if (empty($options)): ?>
        <div class="glass-card rounded-xl p-8 text-center">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-3 block">settings</span>
            <p class="text-sm text-on-surface-variant">
                <?php if (!empty($search) || !empty($typeFilter) || !empty($statusFilter)): ?>
                    Tidak ada opsi yang cocok dengan filter.
                <?php else: ?>
                    Belum ada data opsi custom.
                <?php endif; ?>
            </p>
        </div>
        <?php else: ?>
            <?php foreach($options as $opt): ?>
                <?php
                    $typeClass = '';
                    $typeLabel = strtoupper($opt['type']);
                    if ($opt['type'] === 'size') {
                        $typeClass = 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-500/20';
                    } elseif ($opt['type'] === 'color') {
                        $typeClass = 'bg-pink-100 text-pink-700 border-pink-200 dark:bg-pink-900/30 dark:text-pink-300 dark:border-pink-500/20';
                    } elseif ($opt['type'] === 'addon') {
                        $typeClass = 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-500/20';
                    }
                ?>
                <div class="glass-card rounded-xl p-4 flex flex-col gap-3">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold border <?= $typeClass ?>"><?= $typeLabel ?></span>
                            <?php if ($opt['is_active']): ?>
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500/20 text-[10px] font-bold">AKTIF</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded-full bg-surface-variant/50 text-on-surface-variant text-[10px] font-bold border border-outline-variant/30">NONAKTIF</span>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs text-on-surface-variant">Urutan: <?= esc($opt['sort_order']) ?></span>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-on-surface"><?= esc($opt['name']) ?></p>
                        <p class="text-sm <?= $opt['additional_price'] > 0 ? 'text-primary font-medium' : 'text-on-surface-variant' ?>">
                            Rp <?= number_format($opt['additional_price'], 0, ',', '.') ?>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 pt-1 border-t border-outline-variant/10">
                        <form action="<?= base_url('admin/custom-options/toggle-status/' . $opt['id']) ?>" method="POST" class="inline-flex flex-1">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full flex items-center justify-center gap-1 py-2 rounded-lg border border-outline-variant/30 text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                                <span class="material-symbols-outlined text-base"><?= $opt['is_active'] ? 'visibility_off' : 'visibility' ?></span>
                                <?= $opt['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                            </button>
                        </form>
                        <button type="button" onclick='openEditModal(<?= json_encode($opt) ?>)' class="flex-1 flex items-center justify-center gap-1 py-2 rounded-lg bg-primary/10 text-primary text-xs font-semibold hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-base">edit</span> Edit
                        </button>
                        <button type="button" onclick="openAdminConfirm({ 
                            title: 'Hapus Opsi?', 
                            message: 'Opsi \'<?= esc(addslashes($opt['name'])) ?>\' akan dihapus permanen.', 
                            icon: 'delete', 
                            confirmText: 'Hapus', 
                            confirmClass: 'bg-error text-on-error hover:bg-error/90', 
                            action: '<?= base_url('admin/custom-options/delete/' . $opt['id']) ?>', 
                            method: 'POST' 
                        })" class="flex-1 flex items-center justify-center gap-1 py-2 rounded-lg bg-error/10 text-error text-xs font-semibold hover:bg-error/20 transition-colors">
                            <span class="material-symbols-outlined text-base">delete</span> Hapus
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (isset($pager) && $pager->getPageCount('admin_pagination') > 1): ?>
            <div class="flex justify-center pt-4 pb-2 bg-surface-container-low dark:bg-white/[0.03] rounded-xl p-3">
                <?= $pager->links('admin_pagination', 'admin_pagination') ?>
            </div>
            <?php elseif (isset($pager)): ?>
            <div class="flex justify-center pt-4 pb-2 bg-surface-container-low dark:bg-white/[0.03] rounded-xl p-3">
                <span class="text-xs text-on-surface-variant dark:text-gray-400">Halaman 1 dari 1</span>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Form (Add & Edit) -->
<!-- OVERLAY: overflow-y-auto lets the whole overlay scroll; items-start prevents vertical clip -->
<div class="fixed inset-0 z-[9999] hidden" id="modal-option-form">
    <!-- Backdrop (full-screen, click to close) -->
    <div class="absolute inset-0 bg-black/65 backdrop-blur-sm" onclick="closeModal()"></div>

    <!-- Scroll container: sits above backdrop, allows scrolling on small screens -->
    <div class="relative z-10 min-h-full flex items-start justify-center px-3 sm:px-4 py-6 sm:py-10">
        <!-- Modal Card -->
        <div class="w-full sm:max-w-xl mx-auto bg-white dark:bg-[#1e1c1d] rounded-xl sm:rounded-2xl shadow-2xl border border-outline-variant/20 dark:border-white/10 flex flex-col">

            <!-- Sticky Header -->
            <div class="sticky top-0 z-10 flex items-center justify-between px-4 sm:px-5 py-4 bg-white dark:bg-[#2b2027] border-b border-outline-variant/10 dark:border-white/10 rounded-t-xl sm:rounded-t-2xl">
                <h2 id="modal-title" class="text-lg sm:text-xl font-bold text-on-surface dark:text-white">Tambah Opsi Baru</h2>
                <button type="button" onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-primary-fixed-dim hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors" aria-label="Tutup modal">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <!-- Form -->
            <form id="option-form" method="POST" action="<?= base_url('admin/custom-options/store') ?>">
                <?= csrf_field() ?>

                <!-- Scrollable Body -->
                <div class="px-4 sm:px-5 py-4 sm:py-5 space-y-4">
                    <!-- Type + Urutan: 1 col on mobile, 2 col on sm+ -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-semibold text-on-surface-variant dark:text-gray-300">Type <span class="text-error">*</span></label>
                            <select name="type" id="form-type" required
                                class="w-full bg-surface dark:bg-[#29252a] border border-outline-variant/30 dark:border-white/15 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-primary-container outline-none text-on-surface dark:text-white">
                                <option value="size">Ukuran (Size)</option>
                                <option value="color">Warna/Tema (Color)</option>
                                <option value="addon">Add-on</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-semibold text-on-surface-variant dark:text-gray-300">Urutan <span class="text-error">*</span></label>
                            <input type="number" name="sort_order" id="form-sort" value="1" min="1" required
                                class="w-full bg-surface dark:bg-[#29252a] border border-outline-variant/30 dark:border-white/15 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-primary-container outline-none text-on-surface dark:text-white">
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-on-surface-variant dark:text-gray-300">Nama Opsi <span class="text-error">*</span></label>
                        <input type="text" name="name" id="form-name" placeholder="Contoh: Lampu LED, M..." required
                            class="w-full bg-surface dark:bg-[#29252a] border border-outline-variant/30 dark:border-white/15 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-primary-container outline-none text-on-surface dark:text-white dark:placeholder:text-white/40">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-on-surface-variant dark:text-gray-300">Harga Tambahan (Rp) <span class="text-error">*</span></label>
                        <input type="number" name="additional_price" id="form-price" value="0" min="0" required
                            class="w-full bg-surface dark:bg-[#29252a] border border-outline-variant/30 dark:border-white/15 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-primary-container outline-none text-on-surface dark:text-white">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-on-surface-variant dark:text-gray-300">Status</label>
                        <div class="flex flex-wrap items-center gap-4 pt-1">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="status" id="form-status-aktif" value="aktif" checked
                                    class="text-primary dark:text-primary-fixed-dim focus:ring-0 bg-surface dark:bg-white/5">
                                <span class="text-sm dark:text-gray-300 group-hover:text-on-surface dark:group-hover:text-white transition-colors">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="status" id="form-status-nonaktif" value="nonaktif"
                                    class="text-primary dark:text-primary-fixed-dim focus:ring-0 bg-surface dark:bg-white/5">
                                <span class="text-sm dark:text-gray-300 group-hover:text-on-surface dark:group-hover:text-white transition-colors">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Sticky Footer -->
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 sm:gap-3 px-4 sm:px-5 py-4 border-t border-outline-variant/10 dark:border-white/10 bg-white dark:bg-[#1e1c1d] rounded-b-xl sm:rounded-b-2xl">
                    <button type="button" onclick="closeModal()"
                        class="w-full sm:w-auto px-4 py-2.5 rounded-lg text-sm font-semibold text-on-surface-variant dark:text-gray-400 hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors border border-outline-variant/20 dark:border-white/10">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit"
                        class="w-full sm:w-auto bg-primary text-on-primary px-6 py-2.5 rounded-lg text-sm font-bold shadow-md hover:brightness-110 active:scale-95 transition-all">
                        Simpan Opsi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('modal-option-form');
    const form = document.getElementById('option-form');
    const modalTitle = document.getElementById('modal-title');
    const btnSubmit = document.getElementById('btn-submit');

    // Form Inputs
    const inputType = document.getElementById('form-type');
    const inputSort = document.getElementById('form-sort');
    const inputName = document.getElementById('form-name');
    const inputPrice = document.getElementById('form-price');
    const inputStatusAktif = document.getElementById('form-status-aktif');
    const inputStatusNonaktif = document.getElementById('form-status-nonaktif');

    function _showModal() {
        // Remove hidden, add overflow-y-auto so overlay can scroll on small screens
        modal.classList.remove('hidden');
        modal.classList.add('overflow-y-auto');
        document.body.style.overflow = 'hidden';
        // Scroll overlay back to top each time it opens
        modal.scrollTop = 0;
    }

    function openAddModal() {
        modalTitle.innerText = 'Tambah Opsi Baru';
        btnSubmit.innerText = 'Simpan Opsi';
        form.action = '<?= base_url('admin/custom-options/store') ?>';

        inputType.value = 'size';
        inputSort.value = '1';
        inputName.value = '';
        inputPrice.value = '0';
        inputStatusAktif.checked = true;

        _showModal();
    }

    function openEditModal(optData) {
        modalTitle.innerText = 'Edit Opsi';
        btnSubmit.innerText = 'Simpan Perubahan';
        form.action = '<?= base_url('admin/custom-options/update/') ?>' + optData.id;

        inputType.value = optData.type;
        inputSort.value = optData.sort_order;
        inputName.value = optData.name;
        inputPrice.value = optData.additional_price;

        if (optData.is_active == 1) {
            inputStatusAktif.checked = true;
        } else {
            inputStatusNonaktif.checked = true;
        }

        _showModal();
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('overflow-y-auto');
        document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
</script>

<?= $this->endSection() ?>
