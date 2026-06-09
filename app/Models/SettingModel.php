<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['key', 'value', 'group'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getValue(string $key, ?string $default = null): ?string
    {
        $setting = $this->where('key', $key)->first();
        return $setting ? $setting['value'] : $default;
    }

    public function setValue(string $key, ?string $value, string $group = 'general'): bool
    {
        $existing = $this->where('key', $key)->first();
        $value = $value ?? '';

        if ($existing) {
            return $this->update($existing['id'], ['value' => $value, 'group' => $group]);
        }

        return (bool) $this->insert(['key' => $key, 'value' => $value, 'group' => $group]);
    }

    public function getGroup(string $group): array
    {
        $settings = $this->where('group', $group)->findAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['key']] = $setting['value'];
        }
        return $result;
    }

    public function normalizeWhatsapp(?string $number): string
    {
        $number = preg_replace('/\D+/', '', (string) $number);
        if ($number === '') {
            // TODO: ganti dengan nomor WA asli Aye Bouquet sebelum deploy
            return '6281234567890';
        }
        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }
        if (! str_starts_with($number, '62')) {
            return '62' . $number;
        }
        return $number;
    }

    public function getContactSettings(): array
    {
        $whatsapp = $this->normalizeWhatsapp($this->getValue('contact_whatsapp', $this->getValue('whatsapp_number', '6281234567890')));
        $instagram = $this->getValue('contact_instagram', $this->getValue('instagram_url', ''));

        return [
            'site_name'      => $this->getValue('site_name', 'Aye Bouquet'),
            'site_tagline'   => $this->getValue('site_tagline', 'Hadiah Custom untuk Momen Spesial'),
            'whatsapp'       => $whatsapp,
            'email'          => $this->getValue('contact_email', $this->getValue('email', 'halo@ayebouquet.com')),
            'address'        => $this->getValue('contact_address', $this->getValue('address', 'Alamat toko belum diatur')),
            'instagram'      => $instagram,
            'tiktok'         => $this->getValue('contact_tiktok', ''),
            'marketplace'    => $this->getValue('contact_marketplace', ''),
            'working_hours'  => $this->getValue('working_hours', 'Senin - Sabtu, 09:00 - 18:00 WIB'),
            'pickup_hours'   => $this->getValue('pickup_hours', '10:00 - 17:00 WIB'),
            'delivery_hours' => $this->getValue('delivery_hours', 'Menyesuaikan jadwal kurir'),
            'footer_text'    => $this->getValue('footer_text', 'Hadiah custom untuk setiap momen spesial.'),
            'delivery_info'  => $this->getValue('delivery_info', "Buket dapat diambil langsung di toko atau dikirim menggunakan kurir lokal. Ongkos kirim menyesuaikan jarak dan akan dikonfirmasi melalui WhatsApp."),
            'order_guide'    => $this->getValue('order_guide', "Pilih produk dan varian, tulis catatan custom, masukkan ke keranjang, lalu checkout untuk konfirmasi via WhatsApp."),
            'processing_estimate' => $this->getValue('processing_estimate', 'Estimasi pengerjaan 1-3 hari kerja tergantung tingkat kerumitan custom.'),
            'preorder_note'  => $this->getValue('preorder_note', 'Produk pre-order disarankan dipesan minimal H-1/H-2 sebelum acara.'),
            'free_item_info' => $this->getValue('free_item_info', 'Kartu ucapan tersedia gratis sesuai request; tas jinjing mengikuti stok toko.'),
            'maps_link'      => $this->getValue('google_maps_link', 'https://www.google.com/maps'),
            'maps_embed'     => $this->getValue('google_maps_embed', ''),
            'about_hero_title'       => $this->getValue('about_hero_title', 'Cerita di Balik Setiap Buket'),
            'about_hero_description' => $this->getValue('about_hero_description', 'Berawal dari kecintaan pada seni merangkai bunga, Aye Bouquet hadir untuk membantu Anda merayakan momen-momen paling berharga dengan hadiah yang personal dan penuh makna.'),
            'about_story_title'      => $this->getValue('about_story_title', 'Perjalanan Kami'),
            'about_story_content'    => $this->getValue('about_story_content', 'Setiap buket yang kami buat bukan sekadar produk, melainkan karya seni yang dirangkai dengan tangan dan hati. Kami percaya bahwa setiap perayaan—baik wisuda, ulang tahun, anniversary, hingga hari ibu—memiliki ceritanya sendiri, dan hadiah yang diberikan harus mampu merepresentasikan perasaan yang tak terucapkan.'),
        ];
    }

    public function instagramUrl(?string $instagram): string
    {
        $instagram = trim((string) $instagram);
        if ($instagram === '') {
            return '#';
        }
        if (str_starts_with($instagram, 'http://') || str_starts_with($instagram, 'https://')) {
            return $instagram;
        }
        return 'https://instagram.com/' . ltrim($instagram, '@');
    }

    public function displayWhatsapp(?string $number): string
    {
        $number = $this->normalizeWhatsapp($number);
        return '+' . $number;
    }
}
