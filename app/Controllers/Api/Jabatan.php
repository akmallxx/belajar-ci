<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\JabatanModel;

class Jabatan extends ResourceController
{
    protected $jabatanModel;

    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data = $this->jabatanModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->jabatanModel->find($id);
        if (!$data) {
            return $this->failNotFound('Jabatan tidak ditemukan');
        }
        return $this->respond($data, 200);
    }

    public function create()
    {
        // Ambil data dari parameter URL
        $jabatan = $this->request->getVar('jabatan');

        // Validasi input
        if (!$jabatan) {
            return $this->failValidationErrors(['jabatan' => 'Jabatan is required']);
        }

        // Simpan data
        $data = [
            'jabatan' => $jabatan
        ];

        if (!$this->jabatanModel->save($data)) {
            log_message('error', 'Failed to save data to database.');
            return $this->fail('Failed to save the job position.');
        }

        log_message('info', 'Jabatan berhasil ditambahkan.');
        return $this->respondCreated(['message' => 'Jabatan berhasil ditambahkan.']);
    }

    public function update($id = null)
    {
        // Ambil data dari parameter URL
        $jabatan = $this->request->getVar('jabatan');

        // Validasi input
        if (!$jabatan) {
            return $this->failValidationErrors(['jabatan' => 'Jabatan is required']);
        }

        // Ambil data jabatan yang ada
        $existingJabatan = $this->jabatanModel->find($id);
        if (!$existingJabatan) {
            return $this->failNotFound('Jabatan tidak ditemukan');
        }

        // Hanya perbarui jabatan, id tetap tidak berubah
        $data = [
            'jabatan' => $jabatan
        ];
        $this->jabatanModel->update($id, $data);
        return $this->respond(['message' => 'Jabatan berhasil diperbarui.']);
    }

    public function delete($id = null)
    {
        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            return $this->failNotFound('Jabatan tidak ditemukan');
        }

        $this->jabatanModel->delete($id);
        return $this->respondDeleted(['message' => 'Jabatan berhasil dihapus.']);
    }
}
