<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-on-surface-variant mb-6 flex-wrap">
    <a href="<?= base_url('admin/produk') ?>" class="hover:text-primary transition-colors">Kelola Produk</a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <a href="<?= base_url('admin/produk/edit/' . $product['id']) ?>" class="hover:text-primary transition-colors truncate max-w-xs"><?= esc($product['name']) ?></a>
    <span class="material-symbols-outlined text-sm">chevron_right</span>
    <span class="text-on-surface font-semibold">Kelola Varian</span>
</div>

<!-- Flash Messages -->
<?php if (!empty($flashSuccess)): ?>
<div class="mb-6 p-4 rounded-xl bg-[#DCEFDF] border border-[#C3E6CB] text-[#1E7E34] text-sm font-semibold flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2"><span class="material-symbols-outlined text-lg">check_circle</span><?= esc($flashSuccess) ?></div>
    <button onclick="this.parentElement.remove()"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
<?php endif; ?>
<?php if (!empty($flashError)): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm font-semibold flex items-center justify-between animate-fade-in">
    <div class="flex items-center gap-2"><span class="material-symbols-outlined text-lg">error</span><?= esc($flashError) ?></div>
    <button onclick="this.parentElement.remove()"><span class="material-symbols-outlined text-sm">close</span></button>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <!-- Existing Variants Table -->
    <div class="lg:col-span-3">
        <div class="bg-surface-container-lowest admin-dark-card rounded-2xl soft-shadow border border-outline-variant/20 overflow-hidden card-hover-admin admin-enter">
            <div class="p-6 border-b border-outline-variant/20 flex items-center justify-between">
                <div>
                    <h3 class="font-headline-md text-base font-bold text-on-surface">Varian Aktif</h3>
                    <p class="text-xs text-on-surface-variant mt-0.5">Ukuran dan harga untuk produk ini</p>
                </div>
                <span class="bg-primary-container text-primary text-xs font-bold px-3 py-1 rounded-full"><?= count($variants) ?> varian</span>
            </div>

            <?php if (!empty($variants)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50 text-on-surface-variant font-bold border-b border-outline-variant/20">
                            <th class="py-3 px-6">Ukuran / Label</th>
                            <th class="py-3 px-6">Harga</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        <?php foreach ($variants as $variant): ?>
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-secondary-container dark:bg-secondary-fixed/20 text-on-secondary-container dark:text-secondary-fixed-dim text-sm font-bold">
                                    <?= esc($variant['size_label']) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 font-bold text-primary dark:text-primary-fixed-dim">
                                Rp <?= number_format($variant['price'], 0, ',', '.') ?>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?= $variant['is_active'] ? 'bg-[#E6F4EA] text-[#137333] border border-[#CEEAD6]' : 'bg-[#F1F3F5] text-[#495057] border border-[#E9ECEF]' ?>">
                                    <?= $variant['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button type="button" onclick="openAdminConfirm({ title: 'Hapus Varian?', message: 'Hapus varian <?= esc(addslashes($variant['size_label'])) ?>?', confirmText: 'Ya, Hapus', confirmClass: 'bg-error text-on-error hover:bg-error/90', action: '<?= base_url('admin/varian/delete/' . $variant['id']) ?>', method: 'POST' })" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded-xl transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 block mb-3">tune</span>
                <p class="text-sm text-on-surface-variant">Belum ada varian untuk produk ini.</p>
                <p class="text-xs text-on-surface-variant mt-1">Tambahkan ukuran dan harga di sebelah kanan.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Variant Form -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-6 soft-shadow border border-outline-variant/20 card-hover-admin admin-enter admin-enter-delay-1">
            <h3 class="font-headline-md text-base font-bold text-on-surface border-b border-outline-variant/20 pb-4 mb-5">Tambah Varian Baru</h3>

            <form action="<?= base_url('admin/produk/' . $product['id'] . '/varian/store') ?>" method="post">
                <?= csrf_field() ?>

                <div id="variant-rows" class="space-y-3 mb-4">
                    <!-- Row template -->
                    <div class="variant-row flex flex-col sm:flex-row sm:items-center gap-2">
                        <input type="text" name="size_label[]" placeholder="Ukuran (S, M, L, XL...)" required
                               class="w-full sm:flex-1 px-3 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest dark:bg-white text-sm text-gray-900 dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        <input type="number" name="price[]" placeholder="Harga" min="0" required
                               class="w-full sm:flex-1 px-3 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest dark:bg-white text-sm text-gray-900 dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
                        <button type="button" onclick="removeRow(this)" class="p-2 text-on-surface-variant hover:text-error rounded-xl transition-colors shrink-0">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                </div>

                <button type="button" onclick="addRow()" class="flex items-center gap-1 text-xs text-primary dark:text-primary-fixed-dim font-bold hover:underline mb-6">
                    <span class="material-symbols-outlined text-sm">add</span> Tambah Baris
                </button>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary text-on-primary py-2.5 rounded-full text-sm font-bold shadow-sm hover:bg-on-primary-fixed-variant transition-all">
                        Simpan Varian
                    </button>
                    <a href="<?= base_url('admin/produk/edit/' . $product['id']) ?>" class="flex-1 py-2.5 rounded-full border border-outline-variant/80 text-sm font-bold text-on-surface hover:bg-surface-container transition-colors text-center">
                        Ke Edit Produk
                    </a>
                </div>
            </form>
        </div>

        <!-- Quick Size Presets -->
        <div class="bg-surface-container-lowest admin-dark-card rounded-2xl p-5 soft-shadow border border-outline-variant/20 card-hover-admin admin-enter admin-enter-delay-2">
            <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">Preset Ukuran Cepat</h4>
            <div class="flex flex-wrap gap-2">
                <?php foreach (['S', 'M', 'L', 'XL', 'Jumbo', '8R', '10R', 'Kecil', 'Sedang', 'Besar'] as $preset): ?>
                <button type="button" onclick="addPreset('<?= $preset ?>')"
                        class="px-3 py-1 rounded-full bg-secondary-container/50 text-on-secondary-container text-xs font-bold hover:bg-secondary-container transition-colors border border-outline-variant/20">
                    <?= $preset ?>
                </button>
                <?php endforeach; ?>
            </div>
            <p class="text-[10px] text-on-surface-variant mt-3">Klik preset untuk otomatis mengisi baris kosong pertama.</p>
        </div>
    </div>
</div>

<script>
function addRow() {
    const container = document.getElementById('variant-rows');
    const row = document.createElement('div');
    row.className = 'variant-row flex flex-col sm:flex-row sm:items-center gap-2';
    row.innerHTML = `
        <input type="text" name="size_label[]" placeholder="Ukuran (S, M, L, XL...)"
               class="w-full sm:flex-1 px-3 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest dark:bg-white text-sm text-gray-900 dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
        <input type="number" name="price[]" placeholder="Harga" min="0"
               class="w-full sm:flex-1 px-3 py-2.5 rounded-xl border border-outline-variant bg-surface-container-lowest dark:bg-white text-sm text-gray-900 dark:text-gray-900 placeholder-gray-400 dark:placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary shadow-sm outline-none transition-all">
        <button type="button" onclick="removeRow(this)" class="p-2 text-on-surface-variant hover:text-error rounded-xl transition-colors shrink-0">
            <span class="material-symbols-outlined text-base">close</span>
        </button>
    `;
    container.appendChild(row);
}

function removeRow(btn) {
    const rows = document.querySelectorAll('#variant-rows .variant-row');
    if (rows.length > 1) {
        btn.closest('.variant-row').remove();
    }
}

function addPreset(size) {
    // Find first empty size input
    const rows = document.querySelectorAll('#variant-rows .variant-row');
    for (const row of rows) {
        const sizeInput = row.querySelector('input[name="size_label[]"]');
        if (sizeInput && sizeInput.value.trim() === '') {
            sizeInput.value = size;
            sizeInput.focus();
            return;
        }
    }
    // No empty row found, add one
    addRow();
    const newRow = document.querySelector('#variant-rows .variant-row:last-child');
    newRow.querySelector('input[name="size_label[]"]').value = size;
}
</script>
<?= $this->endSection() ?>
