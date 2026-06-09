<?php

namespace App\Controllers;

use App\Models\FaqModel;
use App\Models\SettingModel;

class Kontak extends BaseController
{
    public function index(): string
    {
        $settingModel = new SettingModel();
        $contacts = $settingModel->getContactSettings();

        $data = [
            'title'      => 'Kontak & Lokasi | Aye Bouquet',
            'activeMenu' => 'kontak',
            'contacts'   => $contacts,
            'waNumber'   => preg_replace('/\D+/', '', $contacts['whatsapp'] ?? '6281234567890'),
            'faqs'       => (new FaqModel())->getActive(),
        ];

        return view('pages/kontak', $data);
    }
}
