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
        // Ambil data dari body request dalam format JSON
        $data = $this->request->getJSON(true);  // true untuk mendapatkan array asosiatif
        log_message('info', 'Data from getJSON: ' . json_encode($data));

        // Validasi input
        if (!$this->validate(['jabatan' => 'required'])) {
            log_message('error', 'Validation errors: ' . json_encode($this->validator->getErrors()));
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Simpan data
        if (!$this->jabatanModel->save($data)) {
            log_message('error', 'Failed to save data to database.');
            return $this->fail('Failed to save the job position.');
        }

        log_message('info', 'Jabatan berhasil ditambahkan.');
        return $this->respondCreated(['message' => 'Jabatan berhasil ditambahkan.']);
    }

    public function update($id = null)
    {
        // Ambil data dari body request dalam format JSON
        $data = $this->request->getJSON(true);  // true untuk mendapatkan array asosiatif

        // Validasi input
        if (!$this->validate(['jabatan' => 'required'])) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Ambil data jabatan yang ada
        $jabatan = $this->jabatanModel->find($id);
        if (!$jabatan) {
            return $this->failNotFound('Jabatan tidak ditemukan');
        }

        // Hanya perbarui jabatan, id tetap tidak berubah
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
