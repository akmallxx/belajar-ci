<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PegawaiFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashData('pesan', 'Login dulu ngab');
            return redirect()->to(base_url('login'));
        }
        if (session()->get('role_id') != 'Pegawai') {
            // session()->setFlashData('pesan', 'Login dulu ngab');
            return redirect()->to(base_url('admin/home'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}