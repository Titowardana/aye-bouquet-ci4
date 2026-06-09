<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomOptionModel;

class CustomOption extends BaseController
{
    protected $customOptionModel;

    public function __construct()
    {
        $this->customOptionModel = new CustomOptionModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $type   = $this->request->getGet('type');
        $status = $this->request->getGet('status');

        $filters = [
            'search' => $search,
            'type'   => $type,
            'status' => $status ?? '',
        ];

        $optionsList = $this->customOptionModel->getFiltered($filters, 15);
        $stats = $this->customOptionModel->getStats();

        $data = [
            'title'       => 'Opsi Custom Order | Admin',
            'pageTitle'   => 'Opsi Custom Order',
            'activeMenu'  => 'custom-options',
            'options'     => $optionsList,
            'pager'       => $this->customOptionModel->pager,
            'search'      => $search,
            'typeFilter'  => $type,
            'statusFilter'=> $status,
            'stats'       => $stats,
        ];

        return view('admin/custom_option/index', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'type'             => 'required|in_list[size,color,addon]',
            'name'             => 'required|max_length[100]',
            'additional_price' => 'required|integer',
            'sort_order'       => 'required|integer',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid. Pastikan semua field terisi dengan benar.');
        }

        $this->customOptionModel->save([
            'type'             => $this->request->getPost('type'),
            'name'             => $this->request->getPost('name'),
            'additional_price' => $this->request->getPost('additional_price'),
            'sort_order'       => $this->request->getPost('sort_order'),
            'is_active'        => $this->request->getPost('status') === 'aktif' ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Opsi custom berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (!$this->validate([
            'type'             => 'required|in_list[size,color,addon]',
            'name'             => 'required|max_length[100]',
            'additional_price' => 'required|integer',
            'sort_order'       => 'required|integer',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid.');
        }

        $this->customOptionModel->update($id, [
            'type'             => $this->request->getPost('type'),
            'name'             => $this->request->getPost('name'),
            'additional_price' => $this->request->getPost('additional_price'),
            'sort_order'       => $this->request->getPost('sort_order'),
            'is_active'        => $this->request->getPost('status') === 'aktif' ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Opsi custom berhasil diperbarui.');
    }

    public function delete($id)
    {
        $option = $this->customOptionModel->find($id);

        if (!$option) {
            return redirect()->back()->with('error', 'Opsi tidak ditemukan.');
        }

        $this->customOptionModel->delete($id);
        return redirect()->back()->with('success', 'Opsi custom berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $option = $this->customOptionModel->find($id);
        if ($option) {
            $this->customOptionModel->update($id, [
                'is_active' => $option['is_active'] ? 0 : 1
            ]);
            return redirect()->back()->with('success', 'Status berhasil diubah.');
        }
        return redirect()->back()->with('error', 'Opsi tidak ditemukan.');
    }
}
