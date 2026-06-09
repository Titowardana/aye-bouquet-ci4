<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    protected $uploadPath;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->uploadPath = FCPATH . 'uploads/categories';
    }

    private function isUploadedCategoryIcon($icon): bool
    {
        if (empty($icon)) {
            return false;
        }
        if (!preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $icon)) {
            return false;
        }
        $real = realpath($this->uploadPath . DIRECTORY_SEPARATOR . $icon);
        $base = realpath($this->uploadPath);
        return $real !== false && $base !== false && str_starts_with($real, $base);
    }

    private function deleteCategoryIconFile($icon): void
    {
        if (!$this->isUploadedCategoryIcon($icon)) {
            return;
        }
        $path = $this->uploadPath . DIRECTORY_SEPARATOR . $icon;
        if (is_file($path)) {
            @unlink($path);
        }
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $keyword = $this->request->getGet('keyword');

        $query = $this->categoryModel;

        if ($status !== null && $status !== '') {
            if ($status === 'Aktif' || $status === '1') {
                $query = $query->where('is_active', 1);
            } elseif ($status === 'Nonaktif' || $status === '0') {
                $query = $query->where('is_active', 0);
            }
        }

        if (!empty($keyword)) {
            $query = $query->like('name', $keyword);
        }

        $categories = $query->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->paginate(9, 'default');

        $data = [
            'title'      => 'Kelola Kategori - Aye Bouquet',
            'activeMenu' => 'categories',
            'categories' => $categories,
            'pager'      => $this->categoryModel->pager,
            'status'     => $status,
            'keyword'    => $keyword
        ];

        return view('admin/category/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Kategori - Aye Bouquet',
            'activeMenu' => 'categories',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/category/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'name' => 'required|max_length[100]',
            'slug' => 'permit_empty|is_unique[categories.slug]',
            'icon' => 'permit_empty|ext_in[icon,jpg,jpeg,png,gif,webp,svg]|mime_in[icon,image/jpg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml]|max_size[icon,2048]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $slug = $this->request->getPost('slug');
        if (empty($slug)) {
            $slug = url_title($name, '-', true);
        }

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }

        $iconFile = $this->request->getFile('icon');
        $iconName = null;
        if ($iconFile && $iconFile->isValid() && !$iconFile->hasMoved()) {
            $iconName = $iconFile->getRandomName();
            $iconFile->move($this->uploadPath, $iconName);
        }

        $this->categoryModel->save([
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'icon'        => $iconName,
            'is_active'   => $this->request->getPost('is_active') !== null ? $this->request->getPost('is_active') : 1,
            'sort_order'  => $this->request->getPost('sort_order') ?? 1
        ]);

        return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'      => 'Edit Kategori - Aye Bouquet',
            'activeMenu' => 'categories',
            'category'   => $category,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/category/edit', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'name' => 'required|max_length[100]',
            'slug' => "permit_empty|is_unique[categories.slug,id,$id]",
            'icon' => 'permit_empty|max_size[icon,2048]|ext_in[icon,jpg,jpeg,png,gif,webp,svg]|mime_in[icon,image/jpg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml,application/octet-stream]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $slug = trim((string) $this->request->getPost('slug'));

        if ($slug === '') {
            $slug = url_title($name, '-', true);
        } else {
            $slug = url_title($slug, '-', true);
        }

        $existingSlug = $this->categoryModel
            ->where('slug', $slug)
            ->where('id !=', $id)
            ->first();

        if ($existingSlug) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['slug' => 'Slug kategori sudah digunakan oleh kategori lain.']);
        }

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }

        $originalIcon = $category['icon'] ?? null;
        $iconName = $originalIcon;

        $iconFile = $this->request->getFile('icon');
        $removeIcon = (string) $this->request->getPost('remove_icon');

        $hasNewIcon = $iconFile
            && $iconFile->getError() !== UPLOAD_ERR_NO_FILE
            && $iconFile->isValid()
            && !$iconFile->hasMoved();

        $uploadedNewFile = false;

        if ($hasNewIcon) {
            $newIconName = $iconFile->getRandomName();

            try {
                $iconFile->move($this->uploadPath, $newIconName);
            } catch (\Throwable $e) {
                log_message('error', 'Gagal upload icon kategori: ' . $e->getMessage());

                return redirect()->back()
                    ->withInput()
                    ->with('errors', ['icon' => 'Gagal mengupload icon kategori baru. Icon lama tetap dipertahankan.']);
            }

            if (!is_file($this->uploadPath . DIRECTORY_SEPARATOR . $newIconName)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', ['icon' => 'File icon baru gagal tersimpan. Icon lama tetap dipertahankan.']);
            }

            $iconName = $newIconName;
            $uploadedNewFile = true;
        } elseif ($removeIcon === '1') {
            $iconName = null;
        }

        $data = [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'icon'        => $iconName,
            'is_active'   => $this->request->getPost('is_active') !== null ? (int) $this->request->getPost('is_active') : 1,
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 1,
        ];

        $this->categoryModel->skipValidation(true);
        $updated = $this->categoryModel->update($id, $data);
        $this->categoryModel->skipValidation(false);

        if (!$updated) {
            if ($uploadedNewFile && !empty($iconName)) {
                $orphanPath = $this->uploadPath . DIRECTORY_SEPARATOR . $iconName;
                if (is_file($orphanPath)) {
                    @unlink($orphanPath);
                }
            }

            $modelErrors = $this->categoryModel->errors();
            $dbError = \Config\Database::connect()->error();

            log_message('error', 'Gagal update kategori ID ' . $id
                . '. Model errors: ' . json_encode($modelErrors)
                . '. DB error: ' . json_encode($dbError));

            $message = 'Gagal menyimpan perubahan kategori.';

            if (!empty($modelErrors)) {
                $message .= ' ' . implode(' ', $modelErrors);
            } elseif (!empty($dbError['message'])) {
                $message .= ' ' . $dbError['message'];
            }

            return redirect()->back()
                ->withInput()
                ->with('errors', ['database' => $message]);
        }

        if ($hasNewIcon) {
            $this->deleteCategoryIconFile($originalIcon);
        } elseif ($removeIcon === '1') {
            $this->deleteCategoryIconFile($originalIcon);
        }

        return redirect()->to(base_url('admin/kategori'))
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('admin/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        // Cek apakah kategori masih memiliki produk
        $productCount = $this->categoryModel->countProducts((int)$id);
        if ($productCount > 0) {
            return redirect()->to('admin/kategori')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki ' . $productCount . ' produk. Pindahkan atau hapus produk tersebut terlebih dahulu.');
        }

        $this->deleteCategoryIconFile($category['icon']);
        $this->categoryModel->delete($id);
        return redirect()->to('admin/kategori')->with('success', 'Kategori berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $id = (int) $id;
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to(base_url('admin/kategori'))->with('error', 'Kategori tidak ditemukan.');
        }

        $newStatus = ((int) $category['is_active'] === 1) ? 0 : 1;

        $db = \Config\Database::connect();
        $db->table('categories')
            ->where('id', $id)
            ->update([
                'is_active'  => $newStatus,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        $afterUpdate = $this->categoryModel->find($id);

        if (!$afterUpdate || (int) $afterUpdate['is_active'] !== $newStatus) {
            log_message('error', '[ToggleStatus] FAILED - ID: ' . $id . ', target: ' . $newStatus . ', actual: ' . ($afterUpdate['is_active'] ?? 'null'));
            return redirect()->to(base_url('admin/kategori'))->with('error', 'Gagal mengubah status kategori. Database tidak terupdate.');
        }

        $message = $newStatus === 1 ? 'Kategori berhasil diaktifkan.' : 'Kategori berhasil dinonaktifkan.';
        return redirect()->to(base_url('admin/kategori'))->with('success', $message);
    }
}
