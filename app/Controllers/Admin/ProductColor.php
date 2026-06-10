<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductColorModel;

class ProductColor extends BaseController
{
    protected ProductColorModel $colorModel;

    public function __construct()
    {
        $this->colorModel = new ProductColorModel();
    }

    public function index()
    {
        $colors = $this->colorModel->getAllColors();

        // Get usage counts per color name (single query)
        $db = \Config\Database::connect();
        $usageRows = $db->table('products')
            ->select('color, COUNT(*) as total')
            ->groupBy('color')
            ->get()
            ->getResultArray();

        $usageMap = [];
        foreach ($usageRows as $row) {
            $usageMap[$row['color']] = (int)$row['total'];
        }

        foreach ($colors as &$color) {
            $color['used_count'] = $usageMap[$color['name']] ?? 0;
        }
        unset($color);

        $data = [
            'title'        => 'Warna Produk - Aye Bouquet',
            'pageTitle'    => 'Warna Produk',
            'activeMenu'   => 'product-colors',
            'colors'       => $colors,
            'flashSuccess' => session()->getFlashdata('success'),
            'flashError'   => session()->getFlashdata('error'),
        ];

        return view('admin/product_color/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Warna - Aye Bouquet',
            'pageTitle'  => 'Tambah Warna Baru',
            'activeMenu' => 'product-colors',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/product_color/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[50]|is_unique[product_colors.name]',
            'hex_code'   => 'permit_empty|regex_match[/^#[0-9a-fA-F]{6}$/]',
            'is_active'  => 'in_list[0,1]',
            'sort_order' => 'integer',
        ];

        $messages = [
            'name' => [
                'required'   => 'Nama warna wajib diisi.',
                'max_length' => 'Nama warna maksimal 50 karakter.',
                'is_unique'  => 'Nama warna sudah digunakan.',
            ],
            'hex_code' => [
                'regex_match' => 'Format hex harus seperti #000000.',
            ],
            'sort_order' => [
                'integer' => 'Urutan tampil harus berupa angka.',
            ],
        ];

        $name = trim($this->request->getPost('name'));
        $name = ucfirst(mb_strtolower($name));

        $hex = trim($this->request->getPost('hex_code'));
        if ($hex !== '') {
            $hex = strtolower($hex);
        }

        $sortOrderRaw = $this->request->getPost('sort_order');
        $isActive  = $this->request->getPost('is_active');

        // Normalize sort_order before validation
        $sortOrder = ($sortOrderRaw === '' || $sortOrderRaw === null || $sortOrderRaw === false) ? 0 : (ctype_digit((string)$sortOrderRaw) ? (int)$sortOrderRaw : $sortOrderRaw);

        if (!$this->validate($rules, $messages, [
            'name'       => $name,
            'hex_code'   => $hex,
            'sort_order' => $sortOrder,
            'is_active'  => $isActive,
        ])) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa form Anda.');
        }

        $this->colorModel->insert([
            'name'       => $name,
            'hex_code'   => $hex ?: null,
            'is_active'  => (int)($isActive ?? 1),
            'sort_order' => $sortOrder,
        ]);

        return redirect()->to(base_url('admin/product-colors'))->with('success', 'Warna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $color = $this->colorModel->find((int)$id);
        if (!$color) {
            return redirect()->to(base_url('admin/product-colors'))->with('error', 'Warna tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Warna - Aye Bouquet',
            'pageTitle'  => 'Edit Warna',
            'activeMenu' => 'product-colors',
            'color'      => $color,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/product_color/edit', $data);
    }

    public function update($id)
    {
        $color = $this->colorModel->find((int)$id);
        if (!$color) {
            return redirect()->to(base_url('admin/product-colors'))->with('error', 'Warna tidak ditemukan.');
        }

        // Normalize input
        $name = trim($this->request->getPost('name'));
        $name = ucfirst(mb_strtolower($name));

        $hex = trim($this->request->getPost('hex_code'));
        if ($hex !== '') {
            $hex = strtolower($hex);
        }

        $sortOrderRaw = $this->request->getPost('sort_order');
        $isActive  = $this->request->getPost('is_active');

        // Manual validation
        $validation = \Config\Services::validation();
        $validation->reset();

        // a. name wajib
        if (empty($name)) {
            $validation->setError('name', 'Nama warna wajib diisi.');
        } elseif (mb_strlen($name) > 50) {
            // b. name max 50
            $validation->setError('name', 'Nama warna maksimal 50 karakter.');
        } else {
            // f. Manual duplicate check — query by name, exclude current ID
            $duplicate = $this->colorModel
                ->where('name', $name)
                ->where('id !=', $id)
                ->first();
            if ($duplicate) {
                $validation->setError('name', 'Nama warna sudah digunakan.');
            }
        }

        // d. hex_code: format check (if filled)
        if ($hex !== '' && !preg_match('/^#[0-9a-fA-F]{6}$/', $hex)) {
            $validation->setError('hex_code', 'Format hex harus seperti #000000.');
        }

        // e. sort_order: normalize & validate
        if ($sortOrderRaw === '' || $sortOrderRaw === null || $sortOrderRaw === false) {
            $sortOrder = 0;
        } elseif (ctype_digit((string)$sortOrderRaw)) {
            $sortOrder = (int)$sortOrderRaw;
        } else {
            $validation->setError('sort_order', 'Urutan tampil harus berupa angka.');
            $sortOrder = 0;
        }

        // Check if any validation errors
        $errors = $validation->getErrors();
        if (!empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa form Anda.')
                ->with('errors', $errors);
        }

        // Update
        $this->colorModel->update((int)$id, [
            'name'       => $name,
            'hex_code'   => $hex ?: null,
            'is_active'  => (int)(($isActive ?? 0) ? 1 : 0),
            'sort_order' => $sortOrder,
        ]);

        return redirect()->to(base_url('admin/product-colors'))->with('success', 'Warna berhasil diperbarui!');
    }

    public function delete($id)
    {
        $color = $this->colorModel->find((int)$id);
        if (!$color) {
            return redirect()->to(base_url('admin/product-colors'))->with('error', 'Warna tidak ditemukan.');
        }

        $usedCount = $this->colorModel->countProducts((int)$id);
        if ($usedCount > 0) {
            $this->colorModel->update((int)$id, ['is_active' => 0]);
            return redirect()->to(base_url('admin/product-colors'))->with('success', "Warna sedang dipakai $usedCount produk. Warna dinonaktifkan (tidak dihapus).");
        }

        $this->colorModel->delete((int)$id);
        return redirect()->to(base_url('admin/product-colors'))->with('success', 'Warna berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $color = $this->colorModel->find((int)$id);
        if (!$color) {
            return redirect()->to(base_url('admin/product-colors'))->with('error', 'Warna tidak ditemukan.');
        }

        $newStatus = $color['is_active'] ? 0 : 1;
        $this->colorModel->update((int)$id, ['is_active' => $newStatus]);

        $msg = $newStatus ? 'Warna berhasil diaktifkan!' : 'Warna berhasil dinonaktifkan!';
        return redirect()->to(base_url('admin/product-colors'))->with('success', $msg);
    }
}
