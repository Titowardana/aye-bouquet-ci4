<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;

class Faq extends BaseController
{
    protected FaqModel $faqModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $category = $this->request->getGet('category');

        $this->faqModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC');

        if (!empty($search)) {
            $this->faqModel->groupStart()
                           ->like('question', $search)
                           ->orLike('answer', $search)
                           ->groupEnd();
        }
        if ($status !== null && $status !== '') {
            $this->faqModel->where('is_active', $status === 'tampil' ? 1 : 0);
        }
        if (!empty($category)) {
            $this->faqModel->where('category', $category);
        }

        $data = [
            'title'      => 'Kelola FAQ - Aye Bouquet',
            'pageTitle'  => 'Kelola FAQ',
            'activeMenu' => 'faqs',
            'faqs'       => $this->faqModel->paginate(10, 'admin_pagination'),
            'pager'      => $this->faqModel->pager,
            'search'     => $search,
            'selectedStatus' => $status,
            'selectedCategory' => $category,
        ];

        return view('admin/faq/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah FAQ - Aye Bouquet',
            'pageTitle'  => 'Tambah FAQ',
            'activeMenu' => 'faqs',
            'faq'        => null,
        ];

        return view('admin/faq/form', $data);
    }

    public function store()
    {
        $rules = [
            'pertanyaan' => 'required|max_length[255]',
            'kategori'   => 'required',
            'jawaban'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Semua field (pertanyaan, kategori, jawaban) wajib diisi.');
        }

        $this->faqModel->insert([
            'question'   => $this->request->getPost('pertanyaan'),
            'category'   => $this->request->getPost('kategori'),
            'answer'     => $this->request->getPost('jawaban'),
            'is_active'  => $this->request->getPost('status') === 'tampil' ? 1 : 0,
            'sort_order' => (int)$this->request->getPost('urutan') ?: 1,
        ]);

        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $faq = $this->faqModel->find($id);
        if (!$faq) {
            return redirect()->to(base_url('admin/faqs'))->with('error', 'FAQ tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit FAQ - Aye Bouquet',
            'pageTitle'  => 'Edit FAQ',
            'activeMenu' => 'faqs',
            'faq'        => $faq,
        ];

        return view('admin/faq/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'pertanyaan' => 'required|max_length[255]',
            'kategori'   => 'required',
            'jawaban'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Semua field (pertanyaan, kategori, jawaban) wajib diisi.');
        }

        $this->faqModel->update($id, [
            'question'   => $this->request->getPost('pertanyaan'),
            'category'   => $this->request->getPost('kategori'),
            'answer'     => $this->request->getPost('jawaban'),
            'is_active'  => $this->request->getPost('status') === 'tampil' ? 1 : 0,
            'sort_order' => (int)$this->request->getPost('urutan') ?: 1,
        ]);

        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $faq = $this->faqModel->find($id);
        if ($faq) {
            $this->faqModel->update($id, ['is_active' => $faq['is_active'] ? 0 : 1]);
        }
        return redirect()->back()->with('success', 'Status FAQ diperbarui.');
    }

    public function delete($id)
    {
        $this->faqModel->delete($id);
        return redirect()->back()->with('success', 'FAQ berhasil dihapus.');
    }
}
