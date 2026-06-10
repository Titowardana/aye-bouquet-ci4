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
</style>

<div class="flex items-center gap-2 text-sm text-on-surface-variant dark:text-white/60 mb-6">
    <a href="<?= base_url('admin') ?>" class="hover:text-primary transition-colors">Dashboard</a>
    <span class="material-symbols-outlined text-base">chevron_right</span>
    <span class="text-on-surface dark:text-white font-medium">Warna Produk</span>
</div>

<?php if (!empty($flashSuccess)): ?>
<div id="flash-success" class="mb-4 px-5 py-4 rounded-2xl bg-success/10 border border-success/20 text-success-text dark:bg-success/15 dark:border-success/25 dark:text-success-text-dark flex items-center gap-3 shadow-sm" role="alert">
    <span class="material-symbols-outlined text-xl flex-shrink-0">check_circle</span>
    <span class="text-sm font-medium"><?= esc($flashSuccess) ?></span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-success-text/60 hover:text-success-text transition-colors" aria-label="Tutup">&times;</button>
</div>
<?php endif; ?>

<?php if (!empty($flashError)): ?>
<div id="flash-error" class="mb-4 px-5 py-4 rounded-2xl bg-error/10 border border-error/20 text-error-text dark:bg-error/15 dark:border-error/25 dark:text-error-text-dark flex items-center gap-3 shadow-sm" role="alert">
    <span class="material-symbols-outlined text-xl flex-shrink-0">error</span>
    <span class="text-sm font-medium"><?= esc($flashError) ?></span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-error-text/60 hover:text-error-text transition-colors" aria-label="Tutup">&times;</button>
</div>
<?php endif; ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h2 class="text-2xl font-bold text-on-surface dark:text-white">Daftar Warna Produk</h2>
    <a href="<?= base_url('admin/product-colors/create') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-on-primary text-sm font-semibold hover:bg-primary/90 transition-all duration-200 shadow-sm w-fit">
        <span class="material-symbols-outlined text-lg">add</span>
        Tambah Warna
    </a>
</div>

<?php if (!empty($colors)): ?>
<!-- Desktop Table -->
<div class="hidden md:block glass-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-surface-container-high dark:bg-white/5 border-b border-outline-variant/20 dark:border-white/10">
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Warna</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider">Hex Code</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider text-center">Status</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider text-center">Urutan</th>
                    <th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                <?php foreach ($colors as $color): ?>
                <?php $isUsed = $color['used_count'] > 0; ?>
                <tr class="bg-white dark:bg-transparent hover:bg-pink-50 dark:hover:bg-[#2b2027] transition-colors group text-on-surface dark:text-gray-100">
                    <td class="px-4 py-3">
                        <div class="w-8 h-8 rounded-full border <?= $color['hex_code'] && strtolower(ltrim($color['hex_code'], '#')) === 'ffffff' ? 'border-outline-variant' : 'border-transparent' ?>" style="background-color: <?= esc($color['hex_code'] ?? '#f0f0f0') ?>"></div>
                    </td>
                    <td class="px-4 py-3 font-semibold text-sm text-on-surface dark:text-white"><?= esc($color['name']) ?></td>
                    <td class="px-4 py-3">
                        <code class="text-xs font-mono text-on-surface-variant dark:text-white/60 px-2 py-1 bg-surface-container-high dark:bg-white/5 rounded-lg"><?= esc($color['hex_code'] ?? '-') ?></code>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <?php if ($color['is_active']): ?>
                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500/20 text-[10px] font-bold">AKTIF</span>
                        <?php else: ?>
                        <span class="px-2 py-1 rounded-full bg-surface-variant/50 text-on-surface-variant dark:text-gray-400 text-[10px] font-bold border border-outline-variant/30">NONAKTIF</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-on-surface-variant dark:text-gray-400"><?= (int)$color['sort_order'] ?></td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end gap-2 opacity-100 md:opacity-60 group-hover:opacity-100 transition-opacity">
                            <a href="<?= base_url('admin/product-colors/edit/' . $color['id']) ?>" class="p-1 text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-primary-fixed-dim transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </a>
                            <form action="<?= base_url('admin/product-colors/toggle-status/' . $color['id']) ?>" method="post" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1 hover:text-tertiary transition-colors" title="<?= $color['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                    <span class="material-symbols-outlined text-xl"><?= $color['is_active'] ? 'visibility_off' : 'visibility' ?></span>
                                </button>
                            </form>
                            <?php if ($isUsed): ?>
                            <span class="relative group/tooltip inline-flex">
                                <button type="button" disabled
                                    class="p-1 text-on-surface-variant dark:text-gray-400 opacity-40 cursor-not-allowed transition-colors"
                                    title="Warna sedang dipakai <?= $color['used_count'] ?> produk, nonaktifkan saja.">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                                <div class="absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block z-50">
                                    <div class="bg-black/85 dark:bg-white/10 text-white dark:text-gray-200 text-[11px] leading-tight rounded-lg px-3 py-2 shadow-lg whitespace-nowrap backdrop-blur-sm max-w-[260px] text-center">
                                        Warna sedang dipakai <?= $color['used_count'] ?> produk, nonaktifkan saja.
                                        <div class="absolute top-full right-4 w-2 h-2 bg-black/85 dark:bg-white/10 rotate-45 -mt-1"></div>
                                    </div>
                                </div>
                            </span>
                            <?php else: ?>
                            <button type="button" onclick="confirmDeleteColor(<?= $color['id'] ?>, '<?= esc($color['name'], 'js') ?>')"
                                class="p-1 text-on-surface-variant dark:text-gray-400 hover:text-error transition-colors"
                                title="Hapus">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile Card Layout -->
<div class="md:hidden space-y-4">
    <?php foreach ($colors as $color): ?>
    <?php $isUsed = $color['used_count'] > 0; ?>
    <div class="glass-card rounded-2xl p-4 flex flex-col gap-3">
        <div class="flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full border <?= $color['hex_code'] && strtolower(ltrim($color['hex_code'], '#')) === 'ffffff' ? 'border-outline-variant' : 'border-transparent' ?>" style="background-color: <?= esc($color['hex_code'] ?? '#f0f0f0') ?>"></div>
                <div>
                    <h3 class="font-semibold text-sm text-on-surface dark:text-white"><?= esc($color['name']) ?></h3>
                    <code class="text-xs font-mono text-on-surface-variant dark:text-white/60"><?= esc($color['hex_code'] ?? '-') ?></code>
                </div>
            </div>
            <?php if ($color['is_active']): ?>
            <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500/20 text-[10px] font-bold">AKTIF</span>
            <?php else: ?>
            <span class="px-2 py-1 rounded-full bg-surface-variant/50 text-on-surface-variant dark:text-gray-400 text-[10px] font-bold border border-outline-variant/30">NONAKTIF</span>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-between text-xs text-on-surface-variant dark:text-white/60">
            <span>Urutan: <?= (int)$color['sort_order'] ?></span>
        </div>
        <div class="flex items-center gap-2 pt-1 border-t border-outline-variant/10">
            <a href="<?= base_url('admin/product-colors/edit/' . $color['id']) ?>" class="flex-1 inline-flex items-center justify-center gap-1 py-2 rounded-lg bg-primary/10 text-primary text-xs font-semibold hover:bg-primary/20 transition-colors">
                <span class="material-symbols-outlined text-base">edit</span> Edit
            </a>
            <form action="<?= base_url('admin/product-colors/toggle-status/' . $color['id']) ?>" method="post" class="flex-1">
                <?= csrf_field() ?>
                <button type="submit" class="w-full flex items-center justify-center gap-1 py-2 rounded-lg border border-outline-variant/30 text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-base"><?= $color['is_active'] ? 'visibility_off' : 'visibility' ?></span>
                    <?= $color['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                </button>
            </form>
            <?php if ($isUsed): ?>
            <span class="relative group/tooltip flex-1">
                <button type="button" disabled
                    class="w-full flex items-center justify-center gap-1 py-2 rounded-lg bg-error/10 text-error/40 text-xs font-semibold cursor-not-allowed">
                    <span class="material-symbols-outlined text-base">delete</span> Hapus
                </button>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/tooltip:block z-50">
                    <div class="bg-black/85 dark:bg-white/10 text-white dark:text-gray-200 text-[11px] leading-tight rounded-lg px-3 py-2 shadow-lg whitespace-nowrap backdrop-blur-sm max-w-[250px] text-center">
                        Warna dipakai <?= $color['used_count'] ?> produk, nonaktifkan saja.
                        <div class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-black/85 dark:bg-white/10 rotate-45 -mt-1"></div>
                    </div>
                </div>
            </span>
            <?php else: ?>
            <button type="button" onclick="confirmDeleteColor(<?= $color['id'] ?>, '<?= esc($color['name'], 'js') ?>')"
                class="flex-1 flex items-center justify-center gap-1 py-2 rounded-lg bg-error/10 text-error text-xs font-semibold hover:bg-error/20 transition-colors">
                <span class="material-symbols-outlined text-base">delete</span> Hapus
            </button>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php else: ?>
<div class="glass-card rounded-2xl p-10 text-center">
    <span class="material-symbols-outlined text-5xl text-on-surface-variant/30 dark:text-white/20 mb-4">palette</span>
    <p class="text-on-surface-variant dark:text-white/60 text-sm">Belum ada warna produk.</p>
    <a href="<?= base_url('admin/product-colors/create') ?>" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-on-primary text-sm font-semibold hover:bg-primary/90 transition-all duration-200 shadow-sm">
        <span class="material-symbols-outlined text-lg">add</span>
        Tambah Warna Pertama
    </a>
</div>
<?php endif; ?>

<script>
function confirmDeleteColor(id, name) {
    openAdminConfirm({
        title: 'Hapus Warna?',
        message: 'Warna "' + name + '" akan dihapus permanen.',
        confirmText: 'Ya, Hapus',
        confirmClass: 'bg-error text-on-error hover:bg-error/90',
        action: '<?= base_url('admin/product-colors/delete/') ?>' + id,
        method: 'POST'
    });
}
</script>

<?= $this->endSection() ?>
