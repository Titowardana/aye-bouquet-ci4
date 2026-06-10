<?php
$settingModel = new \App\Models\SettingModel();
$contact = $settingModel->getContactSettings();
$waNumber = preg_replace('/\D+/', '', $contact['whatsapp'] ?? '6281234567890');
$instagramUrl = $settingModel->instagramUrl($contact['instagram'] ?? '');

$tiktokUrl = trim($contact['tiktok'] ?? '');
if (!empty($tiktokUrl) && !str_starts_with($tiktokUrl, 'http://') && !str_starts_with($tiktokUrl, 'https://')) {
    $tiktokUrl = 'https://tiktok.com/@' . ltrim($tiktokUrl, '@');
}

$marketplaceUrl = trim($contact['marketplace'] ?? '');
if (!empty($marketplaceUrl) && !str_starts_with($marketplaceUrl, 'http://') && !str_starts_with($marketplaceUrl, 'https://')) {
    $marketplaceUrl = 'https://shopee.co.id/' . $marketplaceUrl;
}

$emailAddress = trim($contact['email'] ?? '');
$address = trim($contact['address'] ?? '');
$mapsUrl = trim($contact['maps_link'] ?? '');
?>
<footer class="w-full border-t border-[#E8E3DE]/40 dark:border-white/10 bg-[#E8E3DE] dark:bg-[#1b1619] mt-auto" id="kontak">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-12">

            <!-- Brand & Social Media -->
            <div class="pb-8 border-b border-outline-variant/30 dark:border-white/10 md:pb-0 md:border-b-0">
                <a class="font-headline-md text-headline-md text-on-secondary-container dark:text-white mb-3 block font-bold text-xl" href="<?= base_url('/') ?>">Aye Bouquet</a>
                <p class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 mb-6"><?= esc($contact['footer_text'] ?? 'Hadiah custom untuk setiap momen spesial.') ?></p>

                <?php $hasSocial = (!empty($instagramUrl) && $instagramUrl !== '#') || !empty($tiktokUrl) || !empty($marketplaceUrl) || !empty($emailAddress); ?>
                <?php if ($hasSocial): ?>
                <div class="flex flex-wrap gap-3">
                    <?php if (!empty($instagramUrl) && $instagramUrl !== '#'): ?>
                    <a class="w-11 h-11 rounded-full bg-white/80 dark:bg-white/5 flex items-center justify-center text-on-secondary-container dark:text-white/70 hover:bg-primary hover:text-white dark:hover:bg-primary/20 dark:hover:text-white border border-transparent dark:border-white/10 transition-all" href="<?= esc($instagramUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><span class="material-symbols-outlined text-[20px]">photo_camera</span></a>
                    <?php endif; ?>

                    <?php if (!empty($tiktokUrl)): ?>
                    <a class="w-11 h-11 rounded-full bg-white/80 dark:bg-white/5 flex items-center justify-center text-on-secondary-container dark:text-white/70 hover:bg-primary hover:text-white dark:hover:bg-primary/20 dark:hover:text-white border border-transparent dark:border-white/10 transition-all" href="<?= esc($tiktokUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1.04-.1z"/></svg>
                    </a>
                    <?php endif; ?>

                    <?php if (!empty($marketplaceUrl)): ?>
                    <a class="w-11 h-11 rounded-full bg-white/80 dark:bg-white/5 flex items-center justify-center text-on-secondary-container dark:text-white/70 hover:bg-primary hover:text-white dark:hover:bg-primary/20 dark:hover:text-white border border-transparent dark:border-white/10 transition-all" href="<?= esc($marketplaceUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Marketplace"><span class="material-symbols-outlined text-[20px]">storefront</span></a>
                    <?php endif; ?>

                    <?php if (!empty($emailAddress)): ?>
                    <a class="w-11 h-11 rounded-full bg-white/80 dark:bg-white/5 flex items-center justify-center text-on-secondary-container dark:text-white/70 hover:bg-primary hover:text-white dark:hover:bg-primary/20 dark:hover:text-white border border-transparent dark:border-white/10 transition-all" href="mailto:<?= esc($emailAddress) ?>" aria-label="Email"><span class="material-symbols-outlined text-[20px]">mail</span></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div class="pb-8 border-b border-outline-variant/30 dark:border-white/10 md:pb-0 md:border-b-0">
                <h4 class="font-label-md text-label-md text-on-secondary-container dark:text-white font-bold mb-5 uppercase tracking-wider">Tautan Cepat</h4>
                <ul class="space-y-3">
                    <li><a class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 hover:text-primary dark:hover:text-white hover:underline transition-colors" href="<?= base_url('/katalog') ?>">Katalog</a></li>
                    <li><a class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 hover:text-primary dark:hover:text-white hover:underline transition-colors" href="<?= base_url('/custom-order') ?>">Custom Order</a></li>
                    <li><a class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 hover:text-primary dark:hover:text-white hover:underline transition-colors" href="<?= base_url('/testimoni') ?>">Testimoni</a></li>
                    <li><a class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 hover:text-primary dark:hover:text-white hover:underline transition-colors" href="<?= base_url('/kontak') ?>#faq">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-label-md text-label-md text-on-secondary-container dark:text-white font-bold mb-5 uppercase tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <?php if (!empty($address)): ?>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px] mt-0.5 text-primary dark:text-pink-300 flex-shrink-0">location_on</span>
                        <?php if (!empty($mapsUrl)): ?>
                            <a href="<?= esc($mapsUrl) ?>" target="_blank" rel="noopener noreferrer" class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 hover:underline hover:text-primary dark:hover:text-white transition-colors break-words"><?= esc($address) ?></a>
                        <?php else: ?>
                            <span class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 break-words"><?= esc($address) ?></span>
                        <?php endif; ?>
                    </li>
                    <?php endif; ?>

                    <?php if (!empty($contact['whatsapp'])): ?>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] text-primary dark:text-pink-300 flex-shrink-0">chat</span>
                        <a class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 hover:underline hover:text-primary dark:hover:text-white transition-colors" href="https://wa.me/<?= esc($waNumber) ?>" target="_blank" rel="noopener noreferrer"><?= esc($settingModel->displayWhatsapp($waNumber)) ?> (WA)</a>
                    </li>
                    <?php endif; ?>

                    <?php if (!empty($contact['working_hours'])): ?>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px] mt-0.5 text-primary dark:text-pink-300 flex-shrink-0">schedule</span>
                        <span class="font-body-md text-body-md text-on-secondary-container/70 dark:text-white/70 break-words"><?= esc($contact['working_hours']) ?></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

    <div class="border-t border-outline-variant/30 dark:border-white/10 py-6 text-center px-6">
        <p class="font-body-md text-body-md text-on-secondary-container/60 dark:text-white/60">&copy; <?= date('Y') ?> Aye Bouquet. Crafted with warmth.</p>
    </div>
</footer>
