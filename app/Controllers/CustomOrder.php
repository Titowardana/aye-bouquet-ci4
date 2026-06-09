<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\CategoryModel;
use App\Models\GalleryModel;

class CustomOrder extends BaseController
{
    public function index(): string
    {
        $contacts = (new SettingModel())->getContactSettings();
        $categories = (new CategoryModel())->getActiveCategories();
        $customOptionModel = new \App\Models\CustomOptionModel();

        $data = [
            'title' => 'Custom Order | Aye Bouquet',
            'activeMenu' => 'custom-order',
            'waNumber' => preg_replace('/\D+/', '', $contacts['whatsapp'] ?? '6281234567890'),
            'categories' => $categories,
            'galleries' => (new GalleryModel())->getActive(0, 'product_gallery'),
            'sizeOptions' => $customOptionModel->where('type', 'size')->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'colorOptions' => $customOptionModel->where('type', 'color')->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'addonOptions' => $customOptionModel->where('type', 'addon')->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
        ];

        return view('pages/custom_order', $data);
    }
}
