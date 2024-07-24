<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JabatanModel;

class Jabatan extends BaseController
{
    public function index()
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'title' => 'Data Jabatan',
            'jabatan' => $jabatanModel->findAll()
        ];
        return view('admin/jabatan/jabatan', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jabatan',
        ];
        return view('admin/jabatan/create', $data);
    }

    public function store()
    {
        $jabatanModel = new jabatanModel();
        $jabatanModel->insert([
            'jabatan' => $this->request->getPost('jabatan')
        ]);
        session()->setFlashData('success', 'Data jabatan berhasil disimpan');

        return redirect()->to(base_url('admin/jabatan'));
    }

    public function edit($id)
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'title' => 'Edit Jabatan',
            'jabatan' => $jabatanModel->find($id)
        ];
        return view('admin/jabatan/edit', $data);
    }

    public function update($id)
    {
        $jabatanModel = new jabatanModel();
        $jabatanModel->update($id, [
            'jabatan' => $this->request->getPost('jabatan')
        ]);
        session()->setFlashData('success', 'Data jabatan berhasil diubah');

        return redirect()->to(base_url('admin/jabatan'));
    }

    public function delete($id) {
        $jabatanModel = new JabatanModel();

        $jabatan = $jabatanModel->find($id);
        if ($jabatan) {
            $jabatanModel->delete($id);
            session()->setFlashData('success', 'Data jabatan berhasil dihapus');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }
}
