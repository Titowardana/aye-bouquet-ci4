<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<?php
$productImages = $productImages ?? [];
$primaryImage = null;

if (!function_exists('formatProductDescription')) {
    function formatProductDescription(?string $description): string
    {
        $description = trim($description ?? '');

        if ($description === '') {
            return '<p class="text-[15px] leading-7 text-on-surface-variant">Deskripsi produk belum tersedia.</p>';
        }

        $description = preg_replace('/\s*(Isi:)/i', "\n$1", $description);
        $description = preg_replace('/\s*(Detail:)/i', "\n\n$1", $description);
        $description = preg_replace('/\s*(Harga:)/i', "\n\n$1", $description);
        $description = preg_replace('/\s*(Free:)/i', "\n\n$1", $description);
        $description = trim($description);

        $lines = preg_split('/\n+/', $description);
        $html = '<div class="space-y-3 text-on-surface-variant">';

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $line = esc($line);

            $line = preg_replace('/^(Isi:)/i', '<strong class="text-on-surface">Isi:</strong>', $line);
            $line = preg_replace('/^(Detail:)/i', '<strong class="text-on-surface">Detail:</strong>', $line);
            $line = preg_replace('/^(Harga:)/i', '<strong class="text-on-surface">Harga:</strong>', $line);
            $line = preg_replace('/^(Free:)/i', '<strong class="text-on-surface">Free:</strong>', $line);

            $html .= '<p class="text-[15px] leading-7">' . $line . '</p>';
        }

        $html .= '</div>';

        return $html;
    }
}

foreach ($productImages as $img) {
    if (!empty($img['is_primary'])) {
        $primaryImage = $img['image'];
        break;
    }
}

if (!$primaryImage && !empty($productImages)) {
    $primaryImage = $productImages[0]['image'];
}

$variants = $product['variants'] ?? [];
$contacts = $contacts ?? [];
$deliveryInfo = trim((string)($contacts['delivery_info'] ?? ''));
$orderGuide = trim((string)($contacts['order_guide'] ?? ''));
$processingEstimate = trim((string)($contacts['processing_estimate'] ?? 'Estimasi pengerjaan 1-3 hari kerja tergantung tingkat kerumitan custom.'));
$preorderNote = trim((string)($contacts['preorder_note'] ?? ''));
$freeItemInfo = trim((string)($contacts['free_item_info'] ?? ''));
$basePrice = (int)($product['price'] ?? 0);
$firstVariantPrice = !empty($variants) ? (int)$variants[0]['price'] : $basePrice;

// Mapping gambar per varian sementara berdasarkan urutan.
// Gambar ke-1 = varian ke-1, gambar ke-2 = varian ke-2, dan seterusnya.
$variantImages = [];

if (!empty($variants)) {
    foreach ($variants as $idx => $variant) {
        if (!empty($productImages[$idx]['image'])) {
            $variantImages[$idx] = $productImages[$idx]['image'];
        } else {
            $variantImages[$idx] = $primaryImage;
        }
    }
}
?>

<style>
    .tab-btn.active {
        border-bottom: 2px solid #795465;
        color: #795465;
        font-weight: 700;
    }
    .tab-btn { border-bottom: 2px solid transparent; }
    .thumb-btn.active {
        border-color: #795465;
        box-shadow: 0 0 0 2px #fbf9f8, 0 0 0 4px #795465;
    }
    /* Radio pill selection */
    input[type="radio"].size-radio:checked + .size-pill {
        background-color: #795465;
        color: #ffffff;
        border-color: #795465;
    }
    .soft-shadow { box-shadow: 0 4px 20px rgba(121, 84, 101, 0.07); }
    .soft-shadow-hover:hover { box-shadow: 0 10px 30px rgba(121, 84, 101, 0.12); transform: translateY(-2px); }
        .related-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (min-width: 1024px) {
        #main-product-image {
            min-height: 390px;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="border-b border-surface-container dark:border-white/10 py-4 bg-surface-container-lowest dark:bg-[#211b1f]">
    <div class="w-full px-6 md:px-12 lg:px-16 mx-auto flex items-center gap-2 text-xs font-semibold text-on-surface-variant/80 dark:text-white/60 tracking-wide">
        <a href="<?= base_url('/') ?>" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-base">home</span> Beranda
        </a>
        <span class="material-symbols-outlined text-[12px] text-outline-variant">chevron_right</span>
        <a href="<?= base_url('/katalog?kategori=' . esc($product['category_slug'] ?? '')) ?>" class="hover:text-primary transition-colors"><?= esc($product['category_name']) ?></a>
        <span class="material-symbols-outlined text-[12px] text-outline-variant">chevron_right</span>
        <span class="text-primary font-bold"><?= esc($product['name']) ?></span>
    </div>
</div>

<!-- Product Hero Section -->
<div class="w-full max-w-[1440px] px-5 sm:px-6 md:px-10 lg:px-14 mx-auto py-10">
    <div class="grid grid-cols-1 lg:grid-cols-[minmax(360px,520px)_minmax(0,1fr)] xl:grid-cols-[520px_minmax(0,760px)] gap-8 lg:gap-12 xl:gap-16 items-start">

        <!-- ── Left: Gallery ── -->
        <div class="w-full max-w-[520px] mx-auto lg:mx-0 flex flex-col gap-4 lg:col-start-1 lg:row-start-1">
            <!-- Main Image -->
           <div class="w-full aspect-[4/3] min-h-[260px] sm:min-h-[320px] lg:min-h-[390px] lg:max-h-[430px] rounded-2xl overflow-hidden bg-surface-container soft-shadow relative group cursor-zoom-in">
               <img id="main-product-image"
     src="<?= $primaryImage ? base_url('uploads/products/' . $primaryImage) : base_url('assets/images/no-image.svg') ?>"
     alt="<?= esc($product['name']) ?>"
     onclick="window.openImageModal(this.src)"
     onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'"
     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]">
                <!-- Status Badge -->
                <div class="absolute top-4 left-4">
                    <?php if ($product['status'] === 'ready'): ?>
                        <span class="px-3 py-1.5 rounded-full bg-green-100 text-green-800 text-[11px] font-bold tracking-wider uppercase border border-green-200 shadow-sm">Ready Stock</span>
                    <?php elseif ($product['status'] === 'pre-order'): ?>
                        <span class="px-3 py-1.5 rounded-full bg-amber-100 text-amber-800 text-[11px] font-bold tracking-wider uppercase border border-amber-200 shadow-sm">Pre-order</span>
                    <?php else: ?>
                        <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-800 text-[11px] font-bold tracking-wider uppercase border border-red-200 shadow-sm">Habis</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Thumbnail Grid -->
            <?php if (count($productImages) > 1): ?>
                <div class="grid grid-cols-4 gap-3">
                    <?php foreach ($productImages as $idx => $photo): ?>
                        <button type="button"
                                onclick="window.changeMainImage('<?= base_url('uploads/products/' . esc($photo['image'])) ?>', this)"
                                class="thumb-btn aspect-square rounded-xl overflow-hidden border-2 transition-all duration-200 <?= $idx === 0 ? 'border-primary active' : 'border-outline-variant hover:border-primary opacity-70 hover:opacity-100' ?>">
                            <img src="<?= base_url('uploads/products/' . esc($photo['image'])) ?>" alt="Foto <?= $idx + 1 ?>" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.svg') ?>'">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ── Right: Details & Form ── -->
       <div class="w-full max-w-[680px] flex flex-col lg:col-start-2 lg:row-start-1 lg:row-span-2"> 
            <!-- Header Info -->
            <div class="mb-6">
                <span class="font-label-md text-label-md text-on-surface-variant tracking-widest uppercase mb-2 block"><?= esc($product['category_name']) ?></span>
                <h1 class="font-headline-lg text-2xl md:text-3xl lg:text-4xl text-on-surface mb-3 font-extrabold leading-tight tracking-tight"><?= esc($product['name']) ?></h1>

                <!-- SKU -->
                <?php if (!empty($product['sku'])): ?>
               <div class="flex flex-wrap items-center gap-4 sm:gap-8 border-b border-surface-container dark:border-white/10 mb-8 pb-4">
                    <span class="text-xs text-on-surface-variant font-medium">SKU: <?= esc($product['sku']) ?></span>
                </div>
                <?php endif; ?>

                <!-- Price Display -->
                <div class="mb-5">
                    <span class="text-3xl md:text-4xl font-extrabold text-primary" id="display-price">
                        Rp <?= number_format($firstVariantPrice, 0, ',', '.') ?>
                    </span>
                </div>

               <div class="mb-8">
                 <?= formatProductDescription($product['description'] ?? '') ?>
               </div>
            </div>

            <!-- Customization Form -->
            <form class="flex flex-col gap-6" action="<?= base_url('/keranjang/add') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                <input type="hidden" name="variant_id" id="selected-variant-id" value="<?= !empty($variants[0]['id']) ? (int)$variants[0]['id'] : 0 ?>">
                <input type="hidden" name="custom_notes" id="selected-custom-notes" value="">

                <!-- Size/Variant Selection -->
                <?php if (!empty($variants)): ?>
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <label class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-widest text-xs">
                            <span class="material-symbols-outlined text-sm align-middle mr-1">format_size</span>
                            PILIH UKURAN / VARIAN
                        </label>
                        <span class="text-xs text-on-surface-variant dark:text-white/60 font-medium" id="variant-desc-label">Pilih varian</span>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <?php foreach ($variants as $idx => $variant): ?>
                        <?php
                            $variantImage = $variantImages[$idx] ?? $primaryImage;
                            $variantImageUrl = $variantImage
                                ? base_url('uploads/products/' . $variantImage)
                                : base_url('assets/images/no-image.svg');
                        ?>

                        <label class="cursor-pointer">
                            <input type="radio"
                                name="size"
                                value="<?= esc($variant['size_label']) ?>"
                                class="size-radio sr-only peer"
                                <?= $idx === 0 ? 'checked' : '' ?>
                                data-variant-id="<?= (int)$variant['id'] ?>"
                                data-price="<?= (int)$variant['price'] ?>"
                                data-label="<?= esc($variant['size_label']) ?>"
                                data-desc="<?= esc($variant['description'] ?? '') ?>"
                                data-image="<?= esc($variantImageUrl) ?>">
                                <div class="size-pill rounded-full border border-outline-variant dark:border-white/15 bg-surface-container-lowest dark:bg-[#211b1f] px-5 py-2 text-center hover:bg-surface-container-low dark:hover:bg-white/10 transition-all duration-200 peer-checked:bg-primary peer-checked:text-on-primary peer-checked:border-primary shadow-sm select-none">
                                    <span class="font-label-md text-xs font-bold"><?= esc($variant['size_label']) ?></span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Custom Notes -->
                <div class="rounded-2xl border border-outline-variant/40 dark:border-white/10 bg-surface-container-lowest dark:bg-white/5 p-4">
                    <label for="custom-notes" class="flex items-start gap-2 font-label-md text-xs font-bold text-on-surface dark:text-white mb-3 uppercase tracking-widest leading-relaxed">
                        <span class="material-symbols-outlined text-[18px] text-primary mt-[-1px]">edit_note</span>
                        <span>Catatan Custom / Pesan Kartu <span class="text-on-surface-variant dark:text-white/60 font-semibold normal-case tracking-normal">(Opsional)</span></span>
                    </label>

                    <textarea id="custom-notes"
                            rows="4"
                            placeholder="Contoh: Kartu ucapan: Happy Graduation Sarah! Warna wrapping: pink & putih."
                            class="w-full min-h-[120px] rounded-xl border border-outline-variant/60 dark:border-white/15 bg-white/70 dark:bg-white/5 p-4 text-sm text-on-surface dark:text-white focus:border-primary dark:focus:border-primary-fixed-dim focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none shadow-sm placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40"></textarea>

                    <p class="mt-2 text-[11px] text-on-surface-variant dark:text-white/60">
                        Tulis ucapan, warna wrapping, request bunga, atau instruksi khusus lainnya.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-2">
                    <!-- Add to Cart -->
                    <button type="submit" <?= ($product['status'] ?? 'ready') === 'habis' ? 'disabled title="Produk sedang habis"' : '' ?>
                    class="flex-1 <?= ($product['status'] ?? 'ready') === 'habis' ? 'bg-outline dark:bg-white/10 dark:text-white/40 cursor-not-allowed' : 'bg-primary hover:bg-on-primary-fixed-variant text-on-primary' ?> font-label-md text-sm py-4 px-6 rounded-full shadow-sm transition-all hover:scale-[1.02] active:scale-95 duration-200 flex justify-center items-center gap-2 font-bold">
                        <span class="material-symbols-outlined text-xl">shopping_bag</span>
                        Tambah ke Keranjang
                    </button>
                    <!-- WhatsApp -->
                    <a id="whatsapp-btn"
                    href="#"
                    target="_blank"
                    class="flex-1 bg-surface-container-high dark:bg-white/10 hover:bg-surface-container-highest dark:hover:bg-white/20 text-on-surface dark:text-white font-label-md text-sm py-4 px-6 rounded-full transition-all hover:scale-[1.02] active:scale-95 duration-200 flex justify-center items-center gap-2 font-bold">
                        <span class="material-symbols-outlined text-xl">chat</span>
                        Pesan via WhatsApp
                    </a>
                </div>

                <p class="text-[11px] text-on-surface-variant dark:text-white/60 font-medium italic text-center">
                    * <?= esc($processingEstimate) ?>
                </p>
            </form>
        </div>

        <!-- ── Left Bottom: TABS SECTION ── -->
        <div class="w-full lg:col-start-1 lg:row-start-2 mt-4 lg:mt-0">
            <div class="flex gap-0 border-b border-outline-variant/30 dark:border-white/10 mb-8 overflow-x-auto">
                <button type="button" onclick="window.switchTab('description')" id="tab-btn-description"
                        class="tab-btn active font-label-md text-label-md py-4 px-6 whitespace-nowrap hover:text-primary dark:hover:text-primary-fixed-dim transition-colors">
                    Detail Produk
                </button>
                <button type="button" onclick="window.switchTab('delivery')" id="tab-btn-delivery"
                        class="tab-btn font-label-md text-label-md py-4 px-6 text-on-surface-variant dark:text-white/60 whitespace-nowrap hover:text-primary dark:hover:text-primary-fixed-dim transition-colors">
                    Info Pengiriman
                </button>
                <button type="button" onclick="window.switchTab('care')" id="tab-btn-care"
                        class="tab-btn font-label-md text-label-md py-4 px-6 text-on-surface-variant dark:text-white/60 whitespace-nowrap hover:text-primary dark:hover:text-primary-fixed-dim transition-colors">
                    Cara Pemesanan
                </button>
            </div>

            <!-- Tab: Description -->
            <div id="tab-content-description" class="tab-pane block font-body-md text-body-md text-on-surface-variant dark:text-white/70 max-w-4xl leading-relaxed">
                <ul class="list-disc pl-5 mb-4 space-y-2 text-sm md:text-base">
                    <li><strong class="text-on-surface dark:text-white">Kategori:</strong> <?= esc($product['category_name']) ?></li>
                    <?php if (!empty($product['sku'])): ?>
                    <li><strong class="text-on-surface dark:text-white">SKU:</strong> <?= esc($product['sku']) ?></li>
                    <?php endif; ?>
                    <li><strong class="text-on-surface dark:text-white">Status:</strong> <?= esc(ucfirst($product['status'])) ?></li>
                    <?php if (!empty($variants)): ?>
                    <li><strong class="text-on-surface dark:text-white">Varian Tersedia:</strong>
                        <?php
                        $variantLabels = array_map(function($v) {
                            return $v['size_label'] . ' (Rp ' . number_format($v['price'], 0, ',', '.') . ')';
                        }, $variants);
                        echo esc(implode(', ', $variantLabels));
                        ?>
                    </li>
                    <?php endif; ?>
                </ul>
                <p class="text-sm italic opacity-80 mt-4">* Variasi warna dan bunga pengisi kecil mungkin berbeda tergantung ketersediaan musiman, namun estetika dan nilai keseluruhan tetap konsisten.</p>
            </div>

            <!-- Tab: Delivery -->
            <div id="tab-content-delivery" class="tab-pane hidden font-body-md text-body-md text-on-surface-variant dark:text-white/70 max-w-4xl leading-relaxed">
                <h4 class="font-bold text-on-surface dark:text-white mb-4 text-base uppercase tracking-wide">Ketentuan & Kebijakan Pengiriman</h4>
                <div class="whitespace-pre-line text-sm md:text-base leading-7 dark:text-white/70"><?= esc($deliveryInfo ?: 'Informasi pengiriman belum diatur oleh admin.') ?></div>
                <?php if ($preorderNote !== ''): ?>
                    <div class="mt-5 rounded-xl bg-primary-container/20 dark:bg-primary/20 border border-primary-container dark:border-primary/30 p-4 text-sm"><strong class="text-on-surface dark:text-white">Catatan Pre-order:</strong> <?= esc($preorderNote) ?></div>
                <?php endif; ?>
                <?php if ($freeItemInfo !== ''): ?>
                    <div class="mt-3 rounded-xl bg-secondary-container/30 dark:bg-white/10 border border-secondary-container dark:border-white/15 p-4 text-sm"><strong class="text-on-surface dark:text-white">Free Item:</strong> <?= esc($freeItemInfo) ?></div>
                <?php endif; ?>
            </div>

            <!-- Tab: Care Instructions -->
            <div id="tab-content-care" class="tab-pane hidden font-body-md text-body-md text-on-surface-variant dark:text-white/70 max-w-4xl leading-relaxed">
                <h4 class="font-bold text-on-surface dark:text-white mb-4 text-base uppercase tracking-wide">Langkah Mudah Memesan</h4>
                <div class="whitespace-pre-line text-sm md:text-base leading-7 dark:text-white/70"><?= esc($orderGuide ?: 'Cara pemesanan belum diatur oleh admin.') ?></div>
                <?php if ($processingEstimate !== ''): ?>
                    <div class="mt-5 rounded-xl bg-surface-container-low dark:bg-[#262024] border border-outline-variant/30 dark:border-white/10 p-4 text-sm"><strong class="text-on-surface dark:text-white">Estimasi Pengerjaan:</strong> <?= esc($processingEstimate) ?></div>
                <?php endif; ?>
            </div>
        </div>

    </div> <!-- End Main Grid -->
</div> <!-- End Wrapper -->

<!-- ══ RELATED PRODUCTS ══ -->
<?php if (!empty($related)): ?>
<div class="w-full bg-surface-container-lowest dark:bg-[#1f1b1d] border-t border-surface-container dark:border-white/10 pt-16 pb-24 mt-10">
    <div class="max-w-[1280px] px-5 sm:px-6 md:px-10 lg:px-14 mx-auto">
        <div class="flex flex-col items-center justify-center text-center mb-10">
            <p class="text-xs font-bold text-primary dark:text-primary-fixed-dim uppercase tracking-widest mb-2">Rekomendasi Produk</p>
            <h2 class="font-headline-lg text-2xl md:text-3xl text-on-surface dark:text-white font-extrabold tracking-tight mb-4">
                Mungkin Kamu Suka
            </h2>
            <a href="<?= base_url('katalog') ?>" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
                Lihat Semua Katalog
                <span class="material-symbols-outlined text-base font-bold">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6" data-stagger>
            <?php
            $relImageModel = new \App\Models\ProductImageModel();
            foreach ($related as $rel):
                $relImg = $relImageModel->where('product_id', $rel['id'])->orderBy('is_primary', 'DESC')->first();
                $relImgSrc = $relImg ? base_url('uploads/products/' . $relImg['image']) : base_url('assets/images/no-image.svg');
            ?>
                <article class="group bg-surface-container-lowest dark:bg-[#262024] rounded-2xl overflow-hidden soft-shadow soft-shadow-hover transition-all duration-300 flex flex-col h-full relative min-w-0 border border-outline-variant/30 dark:border-white/10 card-hover animate-on-scroll">
                    <!-- Badge -->
                    <div class="absolute top-4 right-4 bg-surface-container-lowest dark:bg-[#211b1f] px-3 py-1 rounded-full z-10 shadow-sm">
                        <span class="font-label-md text-xs text-on-surface dark:text-white font-bold"><?= esc($rel['category_name']) ?></span>
                    </div>
                    <!-- Image -->
                    <div class="aspect-[4/5] overflow-hidden relative bg-surface-container dark:bg-[#2a2328]">
                        <img alt="<?= esc($rel['name']) ?>"
                             class="related-card-img group-hover:scale-105 transition-transform duration-500"
                             src="<?= $relImgSrc ?>">
                    </div>
                    <!-- Info -->
                    <div class="p-4 md:p-5 flex flex-col flex-grow min-w-0">
                        <span class="font-label-md text-[10px] font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-widest mb-1"><?= esc($rel['category_name']) ?></span>
                        <h3 class="font-headline-md text-sm md:text-base text-on-surface dark:text-white font-bold line-clamp-2 mb-3 group-hover:text-primary dark:group-hover:text-primary-fixed-dim transition-colors min-h-[40px]"> <?= esc($rel['name']) ?> </h3>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mt-auto pt-3 border-t border-surface-container dark:border-white/10">
                            <div>
                                <span class="block text-[10px] text-on-surface-variant dark:text-white/60 font-semibold">Mulai dari</span>
                                <span class="font-body-lg text-sm font-extrabold text-on-surface dark:text-white">Rp <?= number_format($rel['price'], 0, ',', '.') ?></span>
                            </div>
                            <a href="<?= base_url('produk/' . esc($rel['slug'])) ?>"
                               class="inline-flex justify-center items-center gap-1 bg-primary/10 text-primary hover:bg-primary hover:text-on-primary px-4 py-2 rounded-full font-label-sm text-xs font-bold transition-all duration-300 active:scale-95 whitespace-nowrap">
                                Detail <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Image Lightbox Modal -->
<div id="imageModal"
     class="fixed inset-0 z-[9999] bg-black/80 hidden items-center justify-center p-4">
    
    <button type="button"
           onclick="window.closeImageModal()" 
            class="absolute top-5 right-5 w-11 h-11 rounded-full bg-white/90 text-black flex items-center justify-center hover:bg-white transition">
        <span class="material-symbols-outlined">close</span>
    </button>

    <img id="modalImage"
         src=""
         alt="Preview Produk"
         class="max-w-full max-h-[90vh] rounded-2xl object-contain shadow-2xl">
</div>

<!-- ══ JAVASCRIPT ══ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    let selectedPrice = <?= (int)$firstVariantPrice ?>;
    let selectedSize  = "<?= !empty($variants) ? esc($variants[0]['size_label']) : '' ?>";

    const productName = <?= json_encode($product['name'] ?? '-') ?>;
    const productCategory = <?= json_encode($product['category_name'] ?? '-') ?>;
    const productSku = <?= json_encode($product['sku'] ?? '-') ?>;
    const productStatus = <?= json_encode($product['status'] ?? '-') ?>;
    const productLink = <?= json_encode(current_url()) ?>;
    const waNumber = "<?= preg_replace('/\D+/', '', $whatsappNumber ?? '6281234567890') ?>";

    window.formatRupiah = function (value) {
        const numberValue = parseInt(value || 0, 10);

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(numberValue).replace('IDR', 'Rp').trim();
    };

    window.updateWhatsAppUrl = function () {
        const notesInput = document.getElementById('custom-notes');
        const notes = notesInput ? notesInput.value.trim() : '';
        const hiddenNotes = document.getElementById('selected-custom-notes');
        if (hiddenNotes) hiddenNotes.value = notes;
        const priceStr = window.formatRupiah(selectedPrice);

        let msg = `Halo Aye Bouquet, saya ingin memesan produk berikut:\n\n`;
        msg += `Detail Produk:\n`;
        msg += `* Nama Produk: ${productName || '-'}\n`;
        msg += `* Kode Produk/SKU: ${productSku || '-'}\n`;
        msg += `* Kategori: ${productCategory || '-'}\n`;
        msg += `* Varian/Ukuran: ${selectedSize || '-'}\n`;
        msg += `* Harga Estimasi: ${priceStr || '-'}\n`;
        msg += `* Status: ${productStatus || '-'}\n\n`;
        msg += `Catatan Custom:\n${notes || '-'}\n\n`;
        msg += `Link Produk:\n${productLink || '-'}\n\n`;
        msg += `Mohon konfirmasi ketersediaan produk, estimasi pengerjaan, total pembayaran, dan metode pembayaran yang tersedia.\n\n`;
        msg += `Terima kasih.`;

        const btn = document.getElementById('whatsapp-btn');
        if (btn) {
            btn.href = `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;
        }
    };

    window.syncActiveThumbnail = function (src) {
        if (!src) return;

        document.querySelectorAll('.thumb-btn').forEach(function (btn) {
            const img = btn.querySelector('img');
            const imgSrc = img ? img.src : '';

            btn.classList.remove('border-primary', 'active');
            btn.classList.add('border-outline-variant', 'opacity-70');

            if (imgSrc === src) {
                btn.classList.add('border-primary', 'active');
                btn.classList.remove('border-outline-variant', 'opacity-70');
            }
        });
    };

    window.onSizeChange = function (radio) {
        if (!radio) return;

        selectedPrice = parseInt(radio.dataset.price || 0, 10);
        selectedSize = radio.dataset.label || '';

        const selectedVariantInput = document.getElementById('selected-variant-id');
        if (selectedVariantInput) {
            selectedVariantInput.value = radio.dataset.variantId || '0';
        }

        const priceDisplay = document.getElementById('display-price');
        if (priceDisplay) {
            priceDisplay.textContent = window.formatRupiah(selectedPrice);
        }

        const infoBox = document.getElementById('variant-info-box');
        if (infoBox) {
            const desc = radio.dataset.desc || '';
            const priceText = window.formatRupiah(selectedPrice);

            if (desc) {
                infoBox.innerHTML = `Varian <span class="font-semibold text-on-surface">${selectedSize}</span> dipilih - Harga <span class="font-semibold text-primary">${priceText}</span> <span>- ${desc}</span>`;
            } else {
                infoBox.innerHTML = `Varian <span class="font-semibold text-on-surface">${selectedSize}</span> dipilih - Harga <span class="font-semibold text-primary">${priceText}</span>`;
            }
        }

        const label = document.getElementById('variant-desc-label');
        if (label) {
            label.textContent = selectedSize ? 'Dipilih: ' + selectedSize : 'Pilih varian';
        }

        const variantImage = radio.dataset.image;
        const mainImage = document.getElementById('main-product-image');

        if (variantImage && mainImage) {
            mainImage.src = variantImage;
            window.syncActiveThumbnail(variantImage);
        }

        window.updateWhatsAppUrl();
    };

    window.switchTab = function (tabId) {
        document.querySelectorAll('.tab-btn').forEach(function (btn) {
            btn.classList.remove('active');
            btn.classList.add('text-on-surface-variant');
        });

        document.querySelectorAll('.tab-pane').forEach(function (pane) {
            pane.classList.add('hidden');
            pane.classList.remove('block');
        });

        const activeBtn = document.getElementById('tab-btn-' + tabId);
        const activePane = document.getElementById('tab-content-' + tabId);

        if (activeBtn) {
            activeBtn.classList.add('active');
            activeBtn.classList.remove('text-on-surface-variant');
        }

        if (activePane) {
            activePane.classList.remove('hidden');
            activePane.classList.add('block');
        }
    };

    window.changeMainImage = function (src, el) {
        const mainImage = document.getElementById('main-product-image');

        if (mainImage) {
            mainImage.src = src;
        }

        document.querySelectorAll('.thumb-btn').forEach(function (btn) {
            btn.classList.remove('border-primary', 'active');
            btn.classList.add('border-outline-variant', 'opacity-70');
        });

        if (el) {
            el.classList.add('border-primary', 'active');
            el.classList.remove('border-outline-variant', 'opacity-70');
        }
    };

    window.openImageModal = function (src) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');

        if (!modal || !modalImage) return;

        modalImage.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    window.closeImageModal = function () {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');

        if (!modal || !modalImage) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalImage.src = '';
        document.body.style.overflow = '';
    };

    document.querySelectorAll('.size-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            window.onSizeChange(this);
        });
    });

    const customNotes = document.getElementById('custom-notes');
    if (customNotes) {
        customNotes.addEventListener('input', window.updateWhatsAppUrl);
    }

    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('click', function (event) {
            if (event.target === imageModal) {
                window.closeImageModal();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            window.closeImageModal();
        }
    });

    const firstRadio = document.querySelector('input.size-radio:checked') || document.querySelector('input.size-radio');

    if (firstRadio) {
        window.onSizeChange(firstRadio);
    } else {
        window.updateWhatsAppUrl();
    }
});
</script>

<?= $this->endSection() ?>
