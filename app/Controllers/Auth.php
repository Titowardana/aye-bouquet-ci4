<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'Login | Aye Bouquet',
            'activeMenu' => 'login',
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Email dan password wajib diisi.');
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        // Since verifyPassword expects email, but user could input email or username, we use verifyPassword.
        $user      = $userModel->verifyPassword($email, $password);

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Email atau kata sandi salah.');
        }

        if (in_array($user['role'], ['admin', 'superadmin'], true)) {
            return redirect()->back()->withInput()->with('error', 'Akun admin tidak dapat digunakan sebagai akun pelanggan. Silakan login melalui panel admin.');
        }

        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'user_email'=> $user['email'],
            'user_role' => $user['role'],
        ]);

        $redirectUrl = session()->get('redirect_url') ?? base_url('/');
        session()->remove('redirect_url');

        return redirect()->to($redirectUrl)->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'Register | Aye Bouquet',
            'activeMenu' => 'register',
        ];

        return view('auth/register', $data);
    }

    public function attemptRegister()
    {
        $rules = [
            'name'              => 'required|min_length[3]|max_length[100]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'phone'             => 'required|min_length[10]',
            'password'          => 'required|min_length[6]',
            'password_confirm'  => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $userModel->insert([
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'password'  => $this->request->getPost('password'),
            'role'      => 'user',
            'is_active' => 1,
        ]);

        return redirect()->to(base_url('/login'))->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('success', 'Anda telah berhasil keluar.');
    }
}
