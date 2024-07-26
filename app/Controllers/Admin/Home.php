<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => session()->get('role_id') . ' Dashboard'
        ];
        return view('admin/index', $data);
    }
}
