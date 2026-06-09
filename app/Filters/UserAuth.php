<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in') || session()->get('user_role') !== 'user') {
            $redirectUrl = current_url();
            // If the request is POST or contains cart modification actions, redirect back to referer or home instead of the POST route
            if (strcasecmp($request->getMethod(), 'post') === 0 || 
                strpos($redirectUrl, '/add') !== false || 
                strpos($redirectUrl, '/update') !== false || 
                strpos($redirectUrl, '/remove') !== false || 
                strpos($redirectUrl, '/clear') !== false) {
                $redirectUrl = $request->getServer('HTTP_REFERER') ?? base_url('/');
            }
            session()->set('redirect_url', $redirectUrl);
            
            if (session()->get('admin_logged_in')) {
                return redirect()->to(base_url('/login'))->with('error', 'Akun admin tidak dapat melakukan checkout. Silakan gunakan akun pelanggan.');
            }
            
            return redirect()->to(base_url('/login'))->with('error', 'Silakan login terlebih dahulu untuk mengakses keranjang Anda.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
