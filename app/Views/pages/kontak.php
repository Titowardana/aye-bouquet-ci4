<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$contacts = $contacts ?? [];
$waNumber = preg_replace('/\D+/', '', $waNumber ?? ($contacts['whatsapp'] ?? '6281234567890'));
$settingModel = new \App\Models\SettingModel();
$instagramUrl = $settingModel->instagramUrl($contacts['instagram'] ?? '');
$mapsEmbed = trim((string)($contacts['maps_embed'] ?? ''));
if (preg_match('/src=[\"\']([^\"\']+)[\"\']/', $mapsEmbed, $m)) { $mapsEmbed = $m[1]; }
?>
<main class="max-w-[1280px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-section-gap space-y-section-gap bg-warm-cream dark:bg-[#1c191a]">
    <section class="text-center max-w-3xl mx-auto space-y-6 animate-on-scroll relative">
        <!-- Decorative blobs -->
        <div class="hidden md:block deco-blob absolute -top-10 -left-20 w-56 h-56 bg-soft-pink-accent/30 dark:opacity-0 animate-float-slow"></div>
        <div class="hidden md:block deco-blob absolute -bottom-10 -right-20 w-64 h-64 bg-primary-container/20 dark:opacity-0 animate-float" style="animation-delay: 1s"></div>
        <span class="inline-block font-label-md text-xs font-extrabold text-primary dark:text-primary-fixed-dim uppercase tracking-[0.2em] mb-2 animate-on-scroll">Hubungi Kami</span>
        <h1 class="font-display-lg text-4xl md:text-5xl font-bold text-primary dark:text-primary-fixed-dim animate-on-scroll stagger-1">Kontak & Lokasi</h1>
        <p class="font-body-lg text-lg text-on-surface-variant dark:text-white/70 leading-relaxed animate-on-scroll stagger-2">Hubungi kami untuk konsultasi, pemesanan, custom order, informasi stok, dan pengiriman.</p>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start animate-on-scroll">
        <div class="space-y-8 order-1">
            <div class="bg-white-warm dark:bg-[#262024] p-8 rounded-xl shadow-level-1 border border-soft-beige/30 dark:border-white/10 card-hover animate-on-scroll">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-soft-pink-accent/60 dark:bg-primary/25 text-primary dark:text-primary-fixed-dim rounded-full flex items-center justify-center"><span class="material-symbols-outlined">chat</span></div>
                    <div><h2 class="font-headline-md text-2xl font-bold text-on-surface dark:text-white">WhatsApp</h2><p class="font-body-md text-on-surface-variant dark:text-white/70">Respon cepat pada jam operasional</p></div>
                </div>
                <p class="font-headline-md text-2xl text-primary mb-8 font-bold"><?= esc($settingModel->displayWhatsapp($waNumber)) ?></p>
                <a href="https://wa.me/<?= esc($waNumber) ?>?text=<?= rawurlencode('Halo kak, saya ingin bertanya tentang produk Aye Bouquet.') ?>" target="_blank" class="w-full bg-primary hover:bg-surface-tint text-on-primary font-label-md text-sm font-bold py-4 rounded-full transition-colors flex justify-center items-center space-x-2 shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined text-[20px]">chat</span><span>Chat via WhatsApp</span>
                </a>
            </div>

            <div class="bg-white-warm dark:bg-[#262024] p-8 rounded-xl shadow-level-1 border border-soft-beige/30 dark:border-white/10 card-hover animate-on-scroll stagger-1">
                <h2 class="font-headline-md text-2xl font-bold text-on-surface dark:text-white mb-6">Kirim Pertanyaan</h2>
                <form class="space-y-6" id="contactForm">
                    <div><label class="block font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 mb-2" for="name">Nama Lengkap</label><input class="w-full bg-white-warm dark:bg-white/5 border border-soft-beige/30 dark:border-white/15 rounded-lg px-4 py-3 text-on-surface dark:text-white focus:border-primary focus:ring-2 focus:ring-primary-container outline-none placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="name" placeholder="Masukkan nama Anda" type="text" required></div>
                    <div><label class="block font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 mb-2" for="phone">Nomor Telepon / WhatsApp</label><input class="w-full bg-white-warm dark:bg-white/5 border border-soft-beige/30 dark:border-white/15 rounded-lg px-4 py-3 text-on-surface dark:text-white focus:border-primary focus:ring-2 focus:ring-primary-container outline-none placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="phone" placeholder="08..." type="tel" required></div>
                    <div><label class="block font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 mb-2" for="type">Jenis Kebutuhan</label><select class="w-full bg-white-warm dark:bg-[#211b1f] border border-soft-beige/30 dark:border-white/15 rounded-lg px-4 py-3 text-on-surface dark:text-white focus:border-primary focus:ring-2 focus:ring-primary-container outline-none" id="type" required><option value="Tanya Produk">Tanya Produk</option><option value="Custom Order">Custom Order</option><option value="Tanya Pengiriman">Tanya Pengiriman</option><option value="Tanya Pembayaran">Tanya Pembayaran</option><option value="Tanya Ketersediaan Produk">Tanya Ketersediaan Produk</option></select></div>
                    <div><label class="block font-label-md text-sm font-bold text-on-surface-variant dark:text-white/80 mb-2" for="message">Pesan</label><textarea class="w-full bg-white-warm dark:bg-white/5 border border-soft-beige/30 dark:border-white/15 rounded-lg px-4 py-3 text-on-surface dark:text-white focus:border-primary focus:ring-2 focus:ring-primary-container outline-none resize-none placeholder:text-on-surface-variant/50 dark:placeholder:text-white/40" id="message" placeholder="Tuliskan pertanyaan atau detail kebutuhan Anda..." rows="4" required></textarea></div>
                    <button class="w-full bg-primary-container text-on-primary-container hover:bg-primary-fixed font-label-md text-sm font-bold py-4 rounded-full transition-colors flex justify-center items-center space-x-2 shadow-sm hover:shadow-md" type="button" onclick="sendContactToWhatsapp()"><span class="material-symbols-outlined text-[20px]">send</span><span>Kirim Pertanyaan via WhatsApp</span></button>
                </form>
            </div>
        </div>

        <div class="space-y-8 order-2">
            <div>
                <h2 class="font-headline-lg text-3xl font-bold text-primary dark:text-primary-fixed-dim mb-6">Lokasi Kami</h2>
                <div class="bg-white-warm dark:bg-[#262024] rounded-xl overflow-hidden shadow-level-1 border border-soft-beige/30 dark:border-white/10 card-hover">
                    <div class="h-[300px] w-full bg-surface-variant dark:bg-[#2a2328] relative overflow-hidden">
                        <?php if ($mapsEmbed !== ''): ?>
                            <iframe allowfullscreen class="absolute inset-0 w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="<?= esc($mapsEmbed, 'attr') ?>" title="Google Maps Location"></iframe>
                        <?php else: ?>
                            <div class="absolute inset-0 flex items-center justify-center text-center p-8 text-on-surface-variant"><span class="material-symbols-outlined text-5xl block mb-2">map</span><p>Embed Google Maps belum diatur di admin.</p></div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8">
                        <h3 class="font-headline-md text-2xl font-bold text-on-surface dark:text-white mb-4"><?= esc($contacts['site_name'] ?? 'Aye Bouquet') ?></h3>
                        <p class="font-label-sm text-xs font-bold text-secondary dark:text-white/60 mb-1">Alamat Toko</p>
                        <p class="font-body-md text-on-surface-variant dark:text-white/70 mb-6"><?= nl2br(esc($contacts['address'] ?? '-')) ?></p>
                        <?php if (!empty($contacts['maps_link'])): ?><a href="<?= esc($contacts['maps_link']) ?>" target="_blank" class="text-primary hover:text-surface-tint font-label-md text-sm font-bold flex items-center space-x-2"><span class="material-symbols-outlined">location_on</span><span class="underline underline-offset-4">Buka di Google Maps</span></a><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="bg-white-warm dark:bg-[#262024] p-8 rounded-xl shadow-level-1 border border-soft-beige/30 dark:border-white/10 card-hover animate-on-scroll stagger-2">
                <h2 class="font-headline-md text-2xl font-bold text-primary dark:text-primary-fixed-dim mb-6">Jam Operasional</h2>
                <ul class="space-y-4 font-body-md text-on-surface-variant dark:text-white/70">
                    <li class="flex justify-between items-center pb-4 border-b border-soft-beige/30 dark:border-white/10 gap-4"><span class="font-bold text-on-surface dark:text-white">Jam Buka</span><span class="text-right"><?= esc($contacts['working_hours'] ?? '-') ?></span></li>
                    <li class="flex justify-between items-center pb-4 border-b border-soft-beige/30 dark:border-white/10 gap-4"><span class="font-bold text-on-surface dark:text-white">Waktu Pickup</span><span class="text-right"><?= esc($contacts['pickup_hours'] ?? '-') ?></span></li>
                    <li class="flex justify-between items-center gap-4"><span class="font-bold text-on-surface dark:text-white">Waktu Pengiriman</span><span class="text-right"><?= esc($contacts['delivery_hours'] ?? '-') ?></span></li>
                </ul>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white-warm dark:bg-[#262024] p-6 rounded-xl shadow-level-1 border border-soft-beige/30 dark:border-white/10 card-hover">
                    <h3 class="font-label-md text-sm font-bold text-primary dark:text-primary-fixed-dim mb-4 uppercase tracking-wider">Media Sosial & Marketplace</h3>
                    <div class="space-y-3">
                        <?php if (!empty($contacts['instagram'])): ?><a class="flex items-center space-x-3 text-on-surface-variant dark:text-white/70 hover:text-primary dark:hover:text-primary-fixed-dim" href="<?= esc($instagramUrl) ?>" target="_blank"><span class="material-symbols-outlined">camera_alt</span><span>Instagram</span></a><?php endif; ?>
                        <?php if (!empty($contacts['tiktok'])): ?><a class="flex items-center space-x-3 text-on-surface-variant dark:text-white/70 hover:text-primary dark:hover:text-primary-fixed-dim" href="<?= esc($contacts['tiktok']) ?>" target="_blank"><span class="material-symbols-outlined">play_circle</span><span>TikTok</span></a><?php endif; ?>
                        <?php if (!empty($contacts['marketplace'])): ?><a class="flex items-center space-x-3 text-on-surface-variant dark:text-white/70 hover:text-primary dark:hover:text-primary-fixed-dim" href="<?= esc($contacts['marketplace']) ?>" target="_blank"><span class="material-symbols-outlined">storefront</span><span>Marketplace</span></a><?php endif; ?>
                    </div>
                </div>
                <div class="bg-white-warm dark:bg-[#262024] p-6 rounded-xl shadow-level-1 border border-soft-beige/30 dark:border-white/10 card-hover">
                    <h3 class="font-label-md text-sm font-bold text-primary dark:text-primary-fixed-dim mb-4 uppercase tracking-wider">Metode Pembayaran</h3>
                    <div class="space-y-3 text-on-surface-variant dark:text-white/70"><div class="flex items-center space-x-3"><span class="material-symbols-outlined">account_balance</span><span>Bank Transfer</span></div><div class="flex items-center space-x-3"><span class="material-symbols-outlined">qr_code</span><span>QRIS</span></div><p class="text-xs italic bg-white-warm dark:bg-white/5 rounded-lg p-3 dark:text-white/60 border border-soft-beige/30 dark:border-white/10">Pembayaran dilakukan setelah pesanan dikonfirmasi admin melalui WhatsApp. Website tidak memakai payment gateway.</p></div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($faqs)): ?>
    <section id="faq" class="max-w-4xl mx-auto space-y-6 animate-on-scroll">
        <div class="text-center"><h2 class="font-headline-lg text-3xl font-bold text-primary dark:text-primary-fixed-dim mb-2">FAQ</h2><p class="text-on-surface-variant dark:text-white/70">Pertanyaan yang tampil di sini berasal dari menu admin FAQ.</p></div>
        <div class="space-y-4">
            <?php foreach ($faqs as $faq): ?>
                <details class="faq-item bg-white-warm dark:bg-[#262024] border border-soft-beige/30 dark:border-white/10 rounded-xl p-5"><summary class="font-bold text-on-surface dark:text-white"><?= esc($faq['question']) ?></summary><p class="text-on-surface-variant dark:text-white/70 leading-relaxed"><?= nl2br(esc($faq['answer'])) ?></p></details>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</main>
<script>
function sendContactToWhatsapp() {
    const name = document.getElementById('name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const type = document.getElementById('type').value;
    const message = document.getElementById('message').value.trim();
    if (!name || !phone || !message) { alert('Mohon lengkapi nama, nomor WhatsApp, dan pesan terlebih dahulu.'); return; }
    const text = `Halo kak, saya ingin bertanya tentang Aye Bouquet.

Nama: ${name}
Nomor HP: ${phone}
Jenis Kebutuhan: ${type}
Pesan: ${message}`;
    window.open(`https://wa.me/<?= esc($waNumber) ?>?text=${encodeURIComponent(text)}`, '_blank');
}
</script>
<?= $this->endSection() ?>
