<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;

class Testimonial extends BaseController
{
    protected TestimonialModel $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $this->testimonialModel->orderBy('created_at', 'DESC');

        if (!empty($search)) {
            $this->testimonialModel->groupStart()
                                   ->like('customer_name', $search)
                                   ->orLike('message', $search)
                                   ->groupEnd();
        }
        if ($status !== null && $status !== '') {
            $this->testimonialModel->where('is_approved', $status === 'approved' ? 1 : 0);
        }

        $data = [
            'title'      => 'Kelola Testimonial - Aye Bouquet',
            'pageTitle'  => 'Kelola Testimonial',
            'activeMenu' => 'testimonials',
            'testimonials' => $this->testimonialModel->paginate(10, 'admin_pagination'),
            'pager'      => $this->testimonialModel->pager,
            'search'     => $search,
            'selectedStatus' => $status,
        ];

        return view('admin/testimonial/index', $data);
    }

    public function toggleStatus($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        if ($testimonial) {
            $this->testimonialModel->skipValidation(true)->update($id, ['is_approved' => $testimonial['is_approved'] ? 0 : 1]);
        }
        return redirect()->to(base_url('admin/testimonials'))->with('success', 'Status testimonial diperbarui.');
    }

    public function delete($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        if ($testimonial) {
            // Delete photo if exists
            if (!empty($testimonial['photo']) && file_exists(FCPATH . 'uploads/testimonials/' . $testimonial['photo'])) {
                unlink(FCPATH . 'uploads/testimonials/' . $testimonial['photo']);
            }
            $this->testimonialModel->delete($id);
        }
        return redirect()->to(base_url('admin/testimonials'))->with('success', 'Testimonial berhasil dihapus.');
    }
}
