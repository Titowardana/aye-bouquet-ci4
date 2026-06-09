<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * AdminAuth Filter
 *
 * Protects all admin routes from unauthenticated access.
 * Checks both 'admin_logged_in' session and 'admin_role' value.
 */
class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'))
                             ->with('error', 'Silakan login terlebih dahulu.');
        }

        $role = session()->get('admin_role');
        if (!in_array($role, ['admin', 'superadmin'], true)) {
            session()->remove(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
            return redirect()->to(base_url('admin/login'))
                             ->with('error', 'Sesi tidak valid. Silakan login ulang.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed after
    }
}
