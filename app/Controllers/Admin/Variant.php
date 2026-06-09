<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;

class Variant extends BaseController
{
    protected ProductModel $productModel;
    protected ProductVariantModel $variantModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->variantModel = new ProductVariantModel();
    }

    /**
     * List variants for a product
     */
    public function index(int $productId)
    {
        $product = $this->productModel->find($productId);
        if (! $product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'title'        => 'Kelola Varian - Aye Bouquet',
            'pageTitle'    => 'Kelola Varian: ' . $product['name'],
            'activeMenu'   => 'produk',
            'product'      => $product,
            'variants'     => $this->variantModel->getByProduct($productId),
            'flashSuccess' => session()->getFlashdata('success'),
            'flashError'   => session()->getFlashdata('error'),
        ];

        return view('admin/product/variants', $data);
    }

    /**
     * Add one or more variants to a product
     */
    public function store(int $productId)
    {
        $product = $this->productModel->find($productId);
        if (! $product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        $sizes  = $this->request->getPost('size_label') ?? [];
        $prices = $this->request->getPost('price') ?? [];

        $added = 0;
        foreach ($sizes as $i => $size) {
            $size  = trim($size);
            $price = isset($prices[$i]) ? (float) $prices[$i] : 0;

            if ($size !== '' && $price >= 0) {
                $this->variantModel->insert([
                    'product_id' => $productId,
                    'size_label' => $size,
                    'price'      => $price,
                    'sort_order' => $this->variantModel->where('product_id', $productId)->countAllResults() + $added,
                    'is_active'  => 1,
                ]);
                $added++;
            }
        }

        $message = $added > 0 ? "{$added} varian berhasil ditambahkan!" : 'Tidak ada varian yang ditambahkan.';
        return redirect()->to(base_url("admin/produk/{$productId}/varian"))
                         ->with($added > 0 ? 'success' : 'error', $message);
    }

    /**
     * Delete a specific variant
     */
    public function delete(int $variantId)
    {
        $variant = $this->variantModel->find($variantId);
        if (! $variant) {
            return redirect()->back()->with('error', 'Varian tidak ditemukan.');
        }

        $productId = $variant['product_id'];
        $this->variantModel->delete($variantId);

        return redirect()->to(base_url("admin/produk/{$productId}/varian"))
                         ->with('success', 'Varian berhasil dihapus.');
    }
}
