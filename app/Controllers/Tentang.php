<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\SettingModel;
use App\Models\CategoryModel;

class Tentang extends BaseController
{
    public function index(): string
    {
        $settingModel = new SettingModel();
        $galleryModel = new GalleryModel();
        $categoryModel = new CategoryModel();

        $contacts = $settingModel->getContactSettings();

        $data = [
            'title' => 'Tentang Kami | Aye Bouquet',
            'activeMenu' => 'tentang',
            'contacts' => $contacts,
            'aboutStoryGalleries' => $galleryModel->getActive(0, 'about_story'),
            'productGalleries' => $galleryModel->getActive(6, 'product_gallery'),
            'totalProductGalleries' => count($galleryModel->getActive(0, 'product_gallery')),
            'categories' => $categoryModel->getActiveCategories(),
            'waNumber' => $contacts['whatsapp'],
        ];

        return view('pages/tentang', $data);
    }
}