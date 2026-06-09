<?php

namespace App\Controllers;

use App\Models\ProductImageModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;

class Cart extends BaseController
{
    private function getCartItems(): array
    {
        return session_cart_items();
    }

    private function saveCartItems(array $items): void
    {
        session()->set(session_cart_key(), array_values($items));
    }

    public function index(): string
    {
        $cartItems  = $this->getCartItems();
        $subtotal   = array_sum(array_map(static fn($i) => (int)($i['harga'] ?? 0) * (int)($i['qty'] ?? 0), $cartItems));
        $totalItems = array_sum(array_map(static fn($i) => (int)($i['qty'] ?? 0), $cartItems));

        return view('pages/keranjang', [
            'title'      => 'Keranjang Saya | Aye Bouquet',
            'activeMenu' => '',
            'cartItems'  => $cartItems,
            'subtotal'   => $subtotal,
            'totalItems' => $totalItems,
        ]);
    }

    public function addRedirect()
    {
        return redirect()->to(base_url('/katalog'))
            ->with('error', 'Silakan pilih produk terlebih dahulu sebelum menambahkan ke keranjang.');
    }

    public function add()
    {
        $rules = [
            'product_id' => 'required|integer',
            'variant_id' => 'permit_empty|integer',
            'qty'        => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data produk tidak valid.');
        }

        $productId = (int) $this->request->getPost('product_id');
        $variantId = (int) $this->request->getPost('variant_id');
        $qty       = max(1, (int) ($this->request->getPost('qty') ?: 1));
        $notes     = trim((string) $this->request->getPost('custom_notes'));

        $productModel = new ProductModel();
        $variantModel = new ProductVariantModel();
        $imageModel   = new ProductImageModel();

        $product = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('categories.is_active', 1)
            ->where('products.is_active', 1)
            ->find($productId);

        if (! $product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan atau belum aktif.');
        }

        if (($product['status'] ?? 'ready') === 'habis') {
            return redirect()->back()->with('error', 'Produk sedang habis dan belum bisa dipesan.');
        }

        $variant = null;
        if ($variantId > 0) {
            $variant = $variantModel->where('product_id', $productId)
                ->where('is_active', 1)
                ->find($variantId);
        } else {
            // Find default/cheapest variant if available
            $variant = $variantModel->where('product_id', $productId)
                ->where('is_active', 1)
                ->orderBy('price', 'ASC')
                ->orderBy('sort_order', 'ASC')
                ->first();
        }

        if ($variantId > 0 && ! $variant) {
            return redirect()->back()->with('error', 'Varian produk tidak ditemukan atau belum aktif.');
        }

        $image = $imageModel->where('product_id', $productId)
            ->orderBy('is_primary', 'DESC')
            ->orderBy('sort_order', 'ASC')
            ->first();

        $key   = $productId . '_' . ($variant['id'] ?? 0) . '_' . md5($notes);
        $items = $this->getCartItems();
        $found = false;

        foreach ($items as &$item) {
            if (($item['key'] ?? '') === $key) {
                $item['qty'] = (int) ($item['qty'] ?? 0) + $qty;
                $item['catatan'] = $notes;
                $found = true;
                break;
            }
        }
        unset($item);

        if (! $found) {
            $items[] = [
                'key'        => $key,
                'id'         => $key,
                'product_id' => $productId,
                'variant_id' => $variant['id'] ?? null,
                'nama'       => $product['name'],
                'sku'        => $product['sku'] ?? '-',
                'kategori'   => $product['category_name'] ?? '-',
                'foto'       => $image ? base_url('uploads/products/' . $image['image']) : base_url('assets/images/no-image.svg'),
                'ukuran'     => $variant['size_label'] ?? '-',
                'warna'      => '-',
                'status'     => $product['status'] ?? '-',
                'catatan'    => $notes,
                'qty'        => $qty,
                'harga'      => (int) ($variant['price'] ?? $product['price']),
                'slug'       => $product['slug'],
                'link'       => base_url('produk/' . $product['slug']),
            ];
        }

        $this->saveCartItems($items);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update()
    {
        $key   = (string) $this->request->getPost('key');
        $qty   = max(1, (int) $this->request->getPost('qty'));
        $notes = trim((string) $this->request->getPost('custom_notes'));

        $items = $this->getCartItems();
        foreach ($items as &$item) {
            if (($item['key'] ?? '') === $key) {
                $item['qty'] = $qty;
                $item['catatan'] = $notes;
                break;
            }
        }
        unset($item);

        $this->saveCartItems($items);
        return redirect()->to(base_url('/keranjang'))->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove()
    {
        $key = (string) $this->request->getPost('key');
        $items = array_values(array_filter($this->getCartItems(), static fn($item) => ($item['key'] ?? '') !== $key));
        $this->saveCartItems($items);
        return redirect()->to(base_url('/keranjang'))->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->remove(session_cart_key());
        return redirect()->to(base_url('/keranjang'))->with('success', 'Keranjang dikosongkan.');
    }
}
