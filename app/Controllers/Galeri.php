<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\SettingModel;

class Galeri extends BaseController
{
    public function index(): string
    {
        $galleryModel = new GalleryModel();
        $settingModel = new SettingModel();

        $contacts = $settingModel->getContactSettings();

        $data = [
            'title'      => 'Galeri Hasil Produk | Aye Bouquet',
            'activeMenu' => 'galeri', // Maybe not highlighted in nav if it doesn't exist, but it's fine
            'galleries'  => $galleryModel->getActive(0, 'product_gallery'), // get all active
            'contacts'   => $contacts,
            'waNumber'   => $contacts['whatsapp'],
        ];

        return view('pages/galeri', $data);
    }
}
