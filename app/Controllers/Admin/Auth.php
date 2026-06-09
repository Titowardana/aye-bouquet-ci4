<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    /**
     * Show login form
     */
    public function login()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin'));
        }

        $data = [
            'title'      => 'Admin Login - Aye Bouquet',
            'flashError' => session()->getFlashdata('error'),
        ];

        return view('admin/auth/login', $data);
    }

    /**
     * Process login form via POST
     */
    public function attemptLogin()
    {
        // Validate input
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Email dan password wajib diisi dengan benar.');
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->verifyPassword($email, $password);

        if (! $user || ! in_array($user['role'], ['admin', 'superadmin'], true)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Akun ini tidak memiliki akses admin.');
        }

        // Set session
        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => $user['id'],
            'admin_name'      => $user['name'],
            'admin_email'     => $user['email'],
            'admin_role'      => $user['role'],
        ]);

        return redirect()->to(base_url('admin'))
                         ->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    /**
     * Logout and destroy session
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'))
                         ->with('error', 'Anda telah berhasil keluar.');
    }
}
