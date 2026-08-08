<?php

namespace Modules\Jabatan\Controllers\Admin;

use App\Controllers\BaseController;
use Modules\Jabatan\Models\JabatanModel;

class Jabatan extends BaseController
{
    public function index()
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'title'   => 'Data Jabatan',
            'jabatan' => $jabatanModel->findAll()
        ];
        return view('Modules\Jabatan\Views\admin\jabatan', $data);
    }

    public function form($id = null)
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'title'   => $id ? 'Edit Data Jabatan' : 'Tambah Data Jabatan',
            'jabatan' => $id ? $jabatanModel->find($id) : null
        ];
        return view('Modules\Jabatan\Views\admin\form', $data);
    }

    public function save($id = null)
    {
        $jabatanModel = new JabatanModel();
        $saveData = [
            'jabatan' => $this->request->getPost('jabatan')
        ];

        if ($id) {
            $saveData['id'] = $id;
        }

        $jabatanModel->save($saveData);
        session()->setFlashData('success', 'Data jabatan berhasil disimpan');

        return redirect()->to(base_url('admin/jabatan'));
    }

    public function delete($id)
    {
        $jabatanModel = new JabatanModel();
        $jabatan = $jabatanModel->find($id);
        if ($jabatan) {
            $jabatanModel->delete($id);
            session()->setFlashData('success', 'Data jabatan berhasil dihapus');
        }
        return redirect()->to(base_url('admin/jabatan'));
    }
}
