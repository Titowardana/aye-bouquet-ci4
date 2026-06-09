<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Contact extends BaseController
{
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        return view('admin/contact/index', [
            'title'      => 'Kelola Kontak - Aye Bouquet',
            'pageTitle'  => 'Kelola Kontak, Maps & Footer',
            'activeMenu' => 'contact',
            'contacts'   => $this->settingModel->getContactSettings(),
        ]);
    }

    public function update()
    {
        $rules = [
            'whatsapp'      => 'required|min_length[9]',
            'email'         => 'permit_empty|valid_email',
            'address'       => 'required',
            'instagram'     => 'permit_empty',
            'tiktok'        => 'permit_empty|valid_url_strict[http,https]',
            'marketplace'   => 'permit_empty|valid_url_strict[http,https]',
            'maps_link'     => 'permit_empty|valid_url_strict[http,https]',
            'maps_embed'    => 'permit_empty',
            'working_hours' => 'required',
            'pickup_hours'  => 'permit_empty',
            'delivery_hours'=> 'permit_empty',
            'footer_text' => 'permit_empty',
            'delivery_info' => 'permit_empty',
            'order_guide' => 'permit_empty',
            'processing_estimate' => 'permit_empty',
            'preorder_note' => 'permit_empty',
            'free_item_info' => 'permit_empty',
            'about_hero_title' => 'permit_empty',
            'about_hero_description' => 'permit_empty',
            'about_story_title' => 'permit_empty',
            'about_story_content' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Silakan periksa kembali isian kontak, link, dan peta.');
        }

        $whatsapp = $this->settingModel->normalizeWhatsapp($this->request->getPost('whatsapp'));
        $instagram = trim((string) $this->request->getPost('instagram'));
        if (str_starts_with($instagram, '@')) {
            $instagram = substr($instagram, 1);
        }

        $payload = [
            'contact_whatsapp'   => [$whatsapp, 'contact'],
            'contact_email'      => [trim((string) $this->request->getPost('email')), 'contact'],
            'contact_address'    => [trim((string) $this->request->getPost('address')), 'contact'],
            'contact_instagram'  => [$instagram, 'contact'],
            'contact_tiktok'     => [trim((string) $this->request->getPost('tiktok')), 'contact'],
            'contact_marketplace'=> [trim((string) $this->request->getPost('marketplace')), 'contact'],
            'google_maps_link'   => [trim((string) $this->request->getPost('maps_link')), 'contact'],
            'google_maps_embed'  => [trim((string) $this->request->getPost('maps_embed')), 'contact'],
            'working_hours'      => [trim((string) $this->request->getPost('working_hours')), 'contact'],
            'pickup_hours'       => [trim((string) $this->request->getPost('pickup_hours')), 'contact'],
            'delivery_hours'     => [trim((string) $this->request->getPost('delivery_hours')), 'contact'],
            'footer_text'        => [trim((string) $this->request->getPost('footer_text')), 'contact'],
            'delivery_info'      => [trim((string) $this->request->getPost('delivery_info')), 'product_info'],
            'order_guide'        => [trim((string) $this->request->getPost('order_guide')), 'product_info'],
            'processing_estimate'=> [trim((string) $this->request->getPost('processing_estimate')), 'product_info'],
            'preorder_note'      => [trim((string) $this->request->getPost('preorder_note')), 'product_info'],
            'free_item_info'     => [trim((string) $this->request->getPost('free_item_info')), 'product_info'],
            'about_hero_title'       => [trim((string) $this->request->getPost('about_hero_title')), 'about'],
            'about_hero_description' => [trim((string) $this->request->getPost('about_hero_description')), 'about'],
            'about_story_title'      => [trim((string) $this->request->getPost('about_story_title')), 'about'],
            'about_story_content'    => [trim((string) $this->request->getPost('about_story_content')), 'about'],
        ];

        foreach ($payload as $key => [$value, $group]) {
            $this->settingModel->setValue($key, $value, $group);
        }

        // Backward compatibility untuk view lama/seed lama.
        $this->settingModel->setValue('whatsapp_number', $whatsapp, 'contact');
        $this->settingModel->setValue('email', $payload['contact_email'][0], 'contact');
        $this->settingModel->setValue('address', $payload['contact_address'][0], 'contact');
        $this->settingModel->setValue('instagram_url', $instagram, 'contact');

        return redirect()->to(base_url('admin/contact'))->with('success', 'Informasi kontak, footer, dan Google Maps berhasil diperbarui.');
    }
}
