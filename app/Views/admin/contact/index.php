<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="mb-6 md:mb-8 admin-enter">
    <h1 class="font-headline-lg text-2xl md:text-headline-lg text-on-surface mb-1 md:mb-2">Kelola Kontak, Footer &amp; Google Maps</h1>
    <p class="font-body-md text-sm md:text-body-md text-on-surface-variant">Data di halaman kontak, footer, custom order, checkout, dan tombol WhatsApp akan mengikuti pengaturan ini.</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#DCEFDF] border border-[#C3E6CB] text-[#1E7E34] text-sm font-semibold"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 p-4 rounded-xl bg-[#FCE8E6] border border-[#FAD2CF] text-[#C5221F] text-sm font-semibold"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <div class="lg:col-span-8">
        <form action="<?= base_url('admin/contact/update') ?>" method="post" class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 p-6 md:p-8 flex flex-col gap-6 admin-enter">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="whatsapp">Nomor WhatsApp <span class="text-error">*</span></label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="whatsapp" name="whatsapp" type="text" value="<?= old('whatsapp', $contacts['whatsapp'] ?? '') ?>" placeholder="62812xxxx" required>
                    <p class="text-xs text-on-surface-variant mt-1">Boleh 08..., 812..., atau 62812.... Sistem akan menormalkan ke format 62.</p>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="email" name="email" type="email" value="<?= old('email', $contacts['email'] ?? '') ?>" placeholder="halo@tokomu.com">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="instagram">Instagram</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="instagram" name="instagram" type="text" value="<?= old('instagram', $contacts['instagram'] ?? '') ?>" placeholder="username atau https://instagram.com/username">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="tiktok">TikTok</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="tiktok" name="tiktok" type="url" value="<?= old('tiktok', $contacts['tiktok'] ?? '') ?>" placeholder="https://tiktok.com/@username">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="marketplace">Link Marketplace</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="marketplace" name="marketplace" type="url" value="<?= old('marketplace', $contacts['marketplace'] ?? '') ?>" placeholder="https://shopee.co.id/... atau https://tokopedia.com/...">
                </div>
            </div>

            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-2" for="address">Alamat Lengkap Toko <span class="text-error">*</span></label>
                <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="address" name="address" rows="4" required><?= old('address', $contacts['address'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="working_hours">Jam Operasional <span class="text-error">*</span></label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="working_hours" name="working_hours" type="text" value="<?= old('working_hours', $contacts['working_hours'] ?? '') ?>" required>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="pickup_hours">Jam Pickup</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="pickup_hours" name="pickup_hours" type="text" value="<?= old('pickup_hours', $contacts['pickup_hours'] ?? '') ?>">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="delivery_hours">Jam Pengiriman</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="delivery_hours" name="delivery_hours" type="text" value="<?= old('delivery_hours', $contacts['delivery_hours'] ?? '') ?>">
                </div>
            </div>

            <div class="border-t border-outline-variant/30 pt-6 grid grid-cols-1 gap-6">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="maps_link">Link Google Maps</label>
                    <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="maps_link" name="maps_link" type="url" value="<?= old('maps_link', $contacts['maps_link'] ?? '') ?>" placeholder="https://maps.app.goo.gl/...">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="maps_embed">Embed Google Maps</label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3 font-mono text-sm" id="maps_embed" name="maps_embed" rows="5" placeholder="Tempel link src embed atau kode iframe Google Maps"><?= old('maps_embed', $contacts['maps_embed'] ?? '') ?></textarea>
                    <p class="text-xs text-on-surface-variant mt-1">Bisa ditempel kode iframe lengkap. Sistem akan mengambil nilai <code>src</code>-nya secara aman di halaman frontend.</p>
                </div>
            </div>


            <div class="border-t border-outline-variant/30 pt-6 grid grid-cols-1 gap-6">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="footer_text">Footer Text</label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="footer_text" name="footer_text" rows="2"><?= old('footer_text', $contacts['footer_text'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="delivery_info">Info Pengiriman</label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="delivery_info" name="delivery_info" rows="4"><?= old('delivery_info', $contacts['delivery_info'] ?? '') ?></textarea>
                    <p class="text-xs text-on-surface-variant mt-1">Tampil di tab Info Pengiriman pada detail produk.</p>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="order_guide">Cara Pemesanan</label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="order_guide" name="order_guide" rows="4"><?= old('order_guide', $contacts['order_guide'] ?? '') ?></textarea>
                    <p class="text-xs text-on-surface-variant mt-1">Tampil di tab Cara Pemesanan pada detail produk.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="processing_estimate">Estimasi Pengerjaan</label>
                        <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="processing_estimate" name="processing_estimate" rows="3"><?= old('processing_estimate', $contacts['processing_estimate'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="preorder_note">Catatan Pre-order</label>
                        <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="preorder_note" name="preorder_note" rows="3"><?= old('preorder_note', $contacts['preorder_note'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="free_item_info">Info Free Item</label>
                        <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="free_item_info" name="free_item_info" rows="3"><?= old('free_item_info', $contacts['free_item_info'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Pengaturan Tentang Kami -->
            <div class="border-t border-outline-variant/30 pt-6 grid grid-cols-1 gap-6">
                <h3 class="font-bold text-on-surface text-lg">Pengaturan Tentang Kami</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="about_hero_title">Judul Hero Tentang Kami</label>
                        <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="about_hero_title" name="about_hero_title" type="text" value="<?= old('about_hero_title', $contacts['about_hero_title'] ?? '') ?>">
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="about_story_title">Judul Cerita Kami</label>
                        <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="about_story_title" name="about_story_title" type="text" value="<?= old('about_story_title', $contacts['about_story_title'] ?? '') ?>">
                    </div>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="about_hero_description">Deskripsi Hero Tentang Kami</label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="about_hero_description" name="about_hero_description" rows="3"><?= old('about_hero_description', $contacts['about_hero_description'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="about_story_content">Isi Cerita Kami</label>
                    <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-3" id="about_story_content" name="about_story_content" rows="5"><?= old('about_story_content', $contacts['about_story_content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-end pt-4">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-full bg-primary text-on-primary font-label-md text-label-md shadow hover:bg-on-primary-fixed-variant transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <aside class="lg:col-span-4">
        <div class="bg-primary-container/40 rounded-xl border border-primary/10 p-6 lg:sticky lg:top-24 card-hover-admin admin-enter admin-enter-delay-1">
            <h2 class="font-bold text-primary mb-3 flex items-center gap-2"><span class="material-symbols-outlined">info</span> Catatan</h2>
            <p class="text-sm text-on-surface-variant leading-relaxed">Setelah disimpan, nomor WhatsApp ini dipakai oleh halaman Kontak, tombol detail produk, Custom Order, Checkout, serta bagian Hubungi Kami di footer.</p>
        </div>
    </aside>
</div>

<?= $this->endSection() ?>
