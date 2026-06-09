<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;
use App\Models\ProductImageModel;
use App\Models\SettingModel;

class Product extends BaseController
{
    public function index(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $categorySlug = $this->request->getGet('kategori');
        $categoryId = null;

        if ($categorySlug) {
            $cat = $categoryModel->getActiveBySlug($categorySlug);
            // Jika slug kategori tidak aktif/tidak ditemukan, jangan tampilkan semua produk.
            // Ini mencegah kategori nonaktif terlihat membingungkan di frontend.
            $categoryId = $cat ? $cat['id'] : -1;
        }

        $filters = [
            'search'      => $this->request->getGet('search'),
            'status'      => $this->request->getGet('status'),
            'price_range' => $this->request->getGet('price_range'),
            'ukuran'      => $this->request->getGet('ukuran'),
            'warna'       => $this->request->getGet('warna'),
            'sort'        => $this->request->getGet('sort'),
            'category_id' => $categoryId
        ];

        $products = $productModel->getProductsWithCategory($filters, 12);

        // Attach primary image for each product
        $imageModel = new ProductImageModel();
        foreach ($products as &$product) {
            $primaryImg = $imageModel->where('product_id', $product['id'])
                                     ->orderBy('is_primary', 'DESC')
                                     ->first();
            $product['primary_image'] = $primaryImg ? $primaryImg['image'] : null;
        }

        $data = [
            'title'      => 'Katalog Produk | Aye Bouquet',
            'activeMenu' => 'catalog',
            'products'   => $products,
            'categories' => $categoryModel->getActiveCategories(),
            'pager'      => $productModel->pager,
            'search'     => $filters['search'],
            'selectedCategory' => $categorySlug,
            'filters'    => $filters,
        ];

        return view('pages/katalog', $data);
    }

    public function detail(string $slug): string
    {
        $productModel  = new ProductModel();
        $variantModel  = new ProductVariantModel();
        $imageModel    = new ProductImageModel();
        $settingModel  = new SettingModel();

        $product = $productModel->select('products.*, categories.name as category_name, categories.slug as category_slug')
                                ->join('categories', 'categories.id = products.category_id', 'left')
                                ->where('categories.is_active', 1)
                                ->where('products.slug', $slug)
                                ->where('products.is_active', 1)
                                ->first();

        if (! $product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan: ' . $slug);
        }

        $product['variants'] = $variantModel->getByProduct($product['id']);
        $productImages = $imageModel->getByProduct($product['id']);
        $contacts = $settingModel->getContactSettings();
        $whatsappNumber = preg_replace('/\D+/', '', $contacts['whatsapp'] ?? '6281234567890');

        // Related products (same category, excluding current)
        $related = $productModel->select('products.*, categories.name as category_name')
                                ->join('categories', 'categories.id = products.category_id', 'left')
                                ->where('categories.is_active', 1)
                                ->where('products.category_id', $product['category_id'])
                                ->where('products.id !=', $product['id'])
                                ->where('products.is_active', 1)
                                ->limit(4)
                                ->findAll();

        $data = [
        'title'          => esc($product['name']) . ' | Aye Bouquet',
        'activeMenu'     => 'catalog',
        'product'        => $product,
        'productImages'  => $productImages,
        'related'        => $related,
        'whatsappNumber' => $whatsappNumber,
            'contacts'       => $contacts,
    ];

        return view('pages/detail_produk', $data);
    }
}
