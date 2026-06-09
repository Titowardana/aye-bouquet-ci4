<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryModel;

class Gallery extends BaseController
{
    protected GalleryModel $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $status = $this->request->getGet('status');

        $this->galleryModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC');

        if (!empty($search)) {
            $this->galleryModel->groupStart()
                               ->like('title', $search)
                               ->orLike('description', $search)
                               ->groupEnd();
        }
        if (!empty($category)) {
            $this->galleryModel->where('category', $category);
        }
        if ($status !== null && $status !== '') {
            $this->galleryModel->where('is_active', $status);
        }

        $galleries = $this->galleryModel->paginate(12, 'admin_pagination');

        $data = [
            'title'      => 'Kelola Galeri - Aye Bouquet',
            'pageTitle'  => 'Kelola Galeri Hasil Produk',
            'activeMenu' => 'galeri',
            'galleries'  => $galleries,
            'pager'      => $this->galleryModel->pager,
            'search'     => $search,
            'selectedCategory' => $category,
            'selectedStatus' => $status,
            'flashSuccess' => session()->getFlashdata('success'),
            'flashError'   => session()->getFlashdata('error'),
        ];

        return view('admin/gallery/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Foto Galeri - Aye Bouquet',
            'pageTitle'  => 'Tambah Foto Galeri',
            'activeMenu' => 'galeri',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/gallery/form', $data);
    }

    public function store()
    {
        $rules = [
            'title'    => 'required|max_length[150]',
            'category' => 'required',
            'image'    => 'uploaded[image]|max_size[image,2048]|is_image[image]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Pastikan foto dan judul diisi dengan benar.');
        }

        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if (!is_dir(FCPATH . 'uploads/galleries')) {
                mkdir(FCPATH . 'uploads/galleries', 0777, true);
            }
            $file->move(FCPATH . 'uploads/galleries', $newName);

            $this->galleryModel->insert([
                'title'       => $this->request->getPost('title'),
                'image'       => $newName,
                'description' => $this->request->getPost('description'),
                'category'    => $this->request->getPost('category'),
                'is_active'   => $this->request->getPost('status') === 'tampil' ? 1 : 0,
                'sort_order'  => (int)$this->request->getPost('sort_order'),
            ]);

            return redirect()->to(base_url('admin/galeri'))->with('success', 'Foto galeri berhasil ditambahkan!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar.');
    }


    public function edit($id)
    {
        $gallery = $this->galleryModel->find($id);
        if (! $gallery) {
            return redirect()->to(base_url('admin/galeri'))->with('error', 'Galeri tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Foto Galeri - Aye Bouquet',
            'pageTitle'  => 'Edit Foto Galeri',
            'activeMenu' => 'galeri',
            'gallery'    => $gallery,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/gallery/form', $data);
    }

    public function update($id)
    {
        $gallery = $this->galleryModel->find($id);
        if (! $gallery) {
            return redirect()->to(base_url('admin/galeri'))->with('error', 'Galeri tidak ditemukan.');
        }

        $rules = [
            'title'    => 'required|max_length[150]',
            'category' => 'required',
            'image'    => 'permit_empty|max_size[image,2048]|is_image[image]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Pastikan data galeri diisi dengan benar.');
        }

        $imageName = $gallery['image'];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if (! is_dir(FCPATH . 'uploads/galleries')) {
                mkdir(FCPATH . 'uploads/galleries', 0777, true);
            }
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/galleries', $imageName);
            $oldPath = FCPATH . 'uploads/galleries/' . $gallery['image'];
            if (! empty($gallery['image']) && file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $this->galleryModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'image'       => $imageName,
            'description' => $this->request->getPost('description'),
            'category'    => $this->request->getPost('category'),
            'is_active'   => $this->request->getPost('status') === 'tampil' ? 1 : 0,
            'sort_order'  => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to(base_url('admin/galeri'))->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $gallery = $this->galleryModel->find($id);
        if ($gallery) {
            $this->galleryModel->update($id, [
                'is_active' => $gallery['is_active'] ? 0 : 1
            ]);
        }
        return redirect()->back()->with('success', 'Status galeri diperbarui.');
    }

    public function delete($id)
    {
        $gallery = $this->galleryModel->find($id);
        if ($gallery) {
            $path = FCPATH . 'uploads/galleries/' . $gallery['image'];
            if (file_exists($path)) {
                unlink($path);
            }
            $this->galleryModel->delete($id);
            return redirect()->to(base_url('admin/galeri'))->with('success', 'Foto galeri berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'Galeri tidak ditemukan.');
    }
}
