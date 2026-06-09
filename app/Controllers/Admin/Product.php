<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;
use App\Models\ProductImageModel;

class Product extends BaseController
{
    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;
    protected ProductVariantModel $variantModel;
    protected ProductImageModel $imageModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->variantModel  = new ProductVariantModel();
        $this->imageModel    = new ProductImageModel();
    }

    /**
     * List all products with search & filter
     */
    public function index()
    {
        $search     = $this->request->getGet('search');
        $categoryId = $this->request->getGet('category');
        $status     = $this->request->getGet('status');

        $filters = [];
        if ($categoryId) {
            $filters['category_id'] = $categoryId;
        }
        if ($search) {
            $filters['search'] = $search;
        }
        if (!empty($status)) {
            $filters['status'] = $status;
        }

        $products = $this->productModel->getProductsWithCategory($filters, 10, false);

        // Get variants & primary image for each product
        foreach ($products as &$product) {
            $product['variants']      = $this->variantModel->getByProduct($product['id']);
            $product['primary_image'] = $this->productModel->getPrimaryImage($product['id']);
        }

        $data = [
            'title'      => 'Kelola Produk - Aye Bouquet',
            'pageTitle'  => 'Kelola Produk',
            'activeMenu' => 'produk',
            'products'   => $products,
            'categories' => $this->categoryModel->getAllForAdmin(),
            'pager'      => $this->productModel->pager,
            'search'     => $search,
            'selectedCategory' => $categoryId,
            'selectedStatus'   => $status,
            'flashSuccess' => session()->getFlashdata('success'),
            'flashError'   => session()->getFlashdata('error'),
        ];

        return view('admin/product/index', $data);
    }

    /**
     * Show create product form
     */
    public function create()
    {
        $data = [
            'title'      => 'Tambah Produk - Aye Bouquet',
            'pageTitle'  => 'Tambah Produk Baru',
            'activeMenu' => 'produk',
            'categories' => $this->categoryModel->getAllForAdmin(),
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/product/create', $data);
    }

    /**
     * Store a new product
     */
    public function store()
    {
        // Validate
        $rules = [
            'name'        => 'required|max_length[200]',
            'category_id' => 'required|integer',
            'price'       => 'required|numeric',
            'status'      => 'required|in_list[ready,pre-order,habis]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa form Anda.');
        }

        // Generate slug
        $slug = $this->productModel->generateSlug($this->request->getPost('name'));

        // Insert product
        $productId = $this->productModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'slug'        => $slug,
            'sku'         => $this->request->getPost('sku'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'status'      => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_active'   => 1,
        ]);

        // Validate images before processing
        $files = $this->request->getFiles();
        if (isset($files['product_images'])) {
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 5 * 1024 * 1024;
            $uploadPath = FCPATH . 'uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            foreach ($files['product_images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if (!in_array($file->getMimeType(), $allowedMimes)) {
                        return redirect()->back()->withInput()->with('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                    }
                    if ($file->getSize() > $maxSize) {
                        return redirect()->back()->withInput()->with('error', 'Ukuran gambar maksimal 5MB per file.');
                    }
                }
            }
        }

        if (!$productId) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk.');
        }

        // Handle variants
        $variantSizes  = $this->request->getPost('variant_size') ?? [];
        $variantPrices = $this->request->getPost('variant_price') ?? [];

        foreach ($variantSizes as $i => $size) {
            if (!empty($size) && isset($variantPrices[$i]) && $variantPrices[$i] !== '') {
                $this->variantModel->insert([
                    'product_id' => $productId,
                    'size_label' => $size,
                    'price'      => $variantPrices[$i],
                    'sort_order' => $i,
                ]);
            }
        }

        // Handle image upload
        $files = $this->request->getFiles();
        if (isset($files['product_images'])) {
            $uploadPath = FCPATH . 'uploads/products';

            foreach ($files['product_images'] as $index => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);

                    $this->imageModel->insert([
                        'product_id' => $productId,
                        'image'      => $newName,
                        'is_primary' => ($index === 0) ? 1 : 0,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show edit product form
     */
    public function edit($id)
    {
        $product = $this->productModel->getProductDetail((int)$id);

        if (!$product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Produk - Aye Bouquet',
            'pageTitle'  => 'Edit Produk',
            'activeMenu' => 'produk',
            'product'    => $product,
            'categories' => $this->categoryModel->getAllForAdmin(),
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/product/edit', $data);
    }

    /**
     * Update an existing product
     */
    public function update($id)
    {
        $product = $this->productModel->find((int)$id);
        if (!$product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'name'        => 'required|max_length[200]',
            'category_id' => 'required|integer',
            'price'       => 'required|numeric',
            'status'      => 'required|in_list[ready,pre-order,habis]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa form Anda.');
        }

        // Validate new images before processing
        $files = $this->request->getFiles();
        if (isset($files['product_images'])) {
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 5 * 1024 * 1024;
            $uploadPath = FCPATH . 'uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            foreach ($files['product_images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if (!in_array($file->getMimeType(), $allowedMimes)) {
                        return redirect()->back()->withInput()->with('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                    }
                    if ($file->getSize() > $maxSize) {
                        return redirect()->back()->withInput()->with('error', 'Ukuran gambar maksimal 5MB per file.');
                    }
                }
            }
        }

        // Regenerate slug only if name changed
        $slug = $product['slug'];
        if ($this->request->getPost('name') !== $product['name']) {
            $slug = $this->productModel->generateSlug($this->request->getPost('name'), (int)$id);
        }

        // Update product
        $this->productModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'slug'        => $slug,
            'sku'         => $this->request->getPost('sku'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'status'      => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ]);

        // Handle variants: delete old, insert new
        $this->variantModel->where('product_id', $id)->delete();
        $variantSizes  = $this->request->getPost('variant_size') ?? [];
        $variantPrices = $this->request->getPost('variant_price') ?? [];

        foreach ($variantSizes as $i => $size) {
            if (!empty($size) && isset($variantPrices[$i]) && $variantPrices[$i] !== '') {
                $this->variantModel->insert([
                    'product_id' => $id,
                    'size_label' => $size,
                    'price'      => $variantPrices[$i],
                    'sort_order' => $i,
                ]);
            }
        }

        // Handle new image uploads
        $files = $this->request->getFiles();
        if (isset($files['product_images'])) {
            $uploadPath = FCPATH . 'uploads/products';
            $existingImages = $this->imageModel->where('product_id', $id)->countAllResults();

            foreach ($files['product_images'] as $index => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);

                    $this->imageModel->insert([
                        'product_id' => $id,
                        'image'      => $newName,
                        'is_primary' => ($existingImages === 0 && $index === 0) ? 1 : 0,
                        'sort_order' => $existingImages + $index,
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete a product
     */
    public function delete($id)
    {
        $product = $this->productModel->find((int)$id);
        if (!$product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        // Delete associated images from filesystem
        $images = $this->imageModel->where('product_id', $id)->findAll();
        foreach ($images as $image) {
            $filePath = FCPATH . 'uploads/products/' . $image['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete product (cascades to variants and images via FK)
        $this->productModel->delete($id);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Delete a single product image via AJAX
     */
    public function deleteImage($imageId)
    {
        $image = $this->imageModel->find((int)$imageId);
        if (!$image) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gambar tidak ditemukan.']);
        }

        $filePath = FCPATH . 'uploads/products/' . $image['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->imageModel->delete($imageId);

        return $this->response->setJSON(['success' => true, 'message' => 'Gambar berhasil dihapus.']);
    }
}
