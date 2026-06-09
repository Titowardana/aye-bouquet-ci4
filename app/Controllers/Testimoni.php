<?php

namespace App\Controllers;

use App\Models\TestimonialModel;

class Testimoni extends BaseController
{
    public function index(): string
    {
        $testimonialModel = new TestimonialModel();

        $data = [
            'title'        => 'Testimoni | Aye Bouquet',
            'activeMenu'   => 'testimoni',
            'testimonials' => $testimonialModel->getApproved(20),
            'avgRating'    => $testimonialModel->getAverageRating(),
            'totalCount'   => $testimonialModel->where('is_approved', 1)->countAllResults(),
            'validation'   => \Config\Services::validation(),
        ];

        return view('pages/testimoni', $data);
    }

    public function store()
    {
        $rules = [
            'name'   => 'required|max_length[100]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'review' => 'required',
            'city'   => 'permit_empty|max_length[100]',
            'foto'   => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $photoName = null;
        $photoFile = $this->request->getFile('foto');
        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/testimonials';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $photoName = $photoFile->getRandomName();
            $photoFile->move($uploadPath, $photoName);
        }

        $model = new TestimonialModel();
        $model->save([
            'customer_name' => $this->request->getPost('name'),
            'city'          => $this->request->getPost('city'),
            'message'       => $this->request->getPost('review'),
            'rating'        => (int) $this->request->getPost('rating'),
            'photo'         => $photoName,
            'is_approved'   => 0,
        ]);

        return redirect()->to('/testimoni')->with('success', 'Terima kasih! Testimoni Anda telah dikirim dan menunggu persetujuan admin.');
    }
}
