<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\TestimonialModel;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel     = new ProductModel();
        $categoryModel    = new CategoryModel();
        $testimonialModel = new TestimonialModel();

        $featuredProducts = $productModel
                ->select('products.*, categories.name as category_name')
                ->join('categories', 'categories.id = products.category_id', 'left')
                ->where('categories.is_active', 1)
                ->where('products.is_featured', 1)
                ->where('products.is_active', 1)
                ->orderBy('products.sort_order', 'ASC')
                ->limit(6)
                ->findAll();

        // Fallback: If no featured products, just get the latest 6 active products
        if (empty($featuredProducts)) {
            $featuredProducts = $productModel
                    ->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('categories.is_active', 1)
                    ->where('products.is_active', 1)
                    ->orderBy('products.created_at', 'DESC')
                    ->limit(6)
                    ->findAll();
        }

        $imageModel = new \App\Models\ProductImageModel();
        foreach ($featuredProducts as &$product) {
            $primaryImg = $imageModel->where('product_id', $product['id'])
                                     ->orderBy('is_primary', 'DESC')
                                     ->first();
            $product['primary_image'] = $primaryImg ? $primaryImg['image'] : null;
        }

        $data = [
            'title'        => 'Beranda | Aye Bouquet',
            'activeMenu'   => 'home',
            'featuredProducts' => $featuredProducts,
            'categories'   => $categoryModel->getActiveCategories(),
            'testimonials' => $testimonialModel->getApproved(6),
            'avgRating'    => $testimonialModel->getAverageRating(),
        ];

        return view('pages/home', $data);
    }
}
