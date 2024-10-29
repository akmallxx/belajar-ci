<?php

namespace App\Controllers\Api;

use App\Models\LokasiPresensiModel;
use CodeIgniter\RESTful\ResourceController;

class LokasiPresensi extends ResourceController
{
    protected $modelName = 'App\Models\LokasiPresensiModel';
    protected $format    = 'json';

    // Fungsi untuk validasi API key
    private function validateApiKey()
    {
        $apiKey = $this->request->getVar('api_key');
        $validApiKey = env('app.API_KEY'); // Ambil API key dari environment

        if (!$apiKey || $apiKey !== $validApiKey) {
            return false;
        }

        return true;
    }

    // GET /lokasi_presensi
    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->findAll();

        return $this->respond($lokasiPresensi);
    }

    // GET /lokasi_presensi/{id}
    public function show($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->find($id);

        if (!$lokasiPresensi) {
            return $this->failNotFound('Data lokasi presensi tidak ditemukan');
        }

        return $this->respond($lokasiPresensi);
    }

    // POST /lokasi_presensi
    public function create()
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        // Using getPost() to get input data from the form or request
        $data = [
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi' => $this->request->getPost('tipe_lokasi'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'radius' => $this->request->getPost('radius'),
            'zona_waktu' => $this->request->getPost('zona_waktu'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_pulang' => $this->request->getPost('jam_pulang'),
        ];

        $LokasiPresensiModel = new LokasiPresensiModel();
        $LokasiPresensiModel->insert($data);

        return $this->respondCreated([
            'message' => 'Data lokasi presensi berhasil disimpan'
        ]);
    }

    // PUT /lokasi_presensi/{id}
    public function update($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        // Using getVar() to handle both PUT and POST request data
        $data = [
            'nama_lokasi' => $this->request->getVar('nama_lokasi'),
            'alamat_lokasi' => $this->request->getVar('alamat_lokasi'),
            'tipe_lokasi' => $this->request->getVar('tipe_lokasi'),
            'latitude' => $this->request->getVar('latitude'),
            'longitude' => $this->request->getVar('longitude'),
            'radius' => $this->request->getVar('radius'),
            'zona_waktu' => $this->request->getVar('zona_waktu'),
            'jam_masuk' => $this->request->getVar('jam_masuk'),
            'jam_pulang' => $this->request->getVar('jam_pulang'),
        ];

        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->find($id);

        if (!$lokasiPresensi) {
            return $this->failNotFound('Data lokasi presensi tidak ditemukan');
        }

        $LokasiPresensiModel->update($id, $data);

        return $this->respond([
            'message' => 'Data lokasi presensi berhasil diubah'
        ]);
    }

    // DELETE /lokasi_presensi/{id}
    public function delete($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->find($id);

        if (!$lokasiPresensi) {
            return $this->failNotFound('Data lokasi presensi tidak ditemukan');
        }

        $LokasiPresensiModel->delete($id);

        return $this->respondDeleted([
            'message' => 'Data lokasi presensi berhasil dihapus'
        ]);
    }
}
