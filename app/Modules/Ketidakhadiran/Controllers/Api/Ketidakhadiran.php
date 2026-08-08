<?php

namespace Modules\Ketidakhadiran\Controllers\Api;

use Modules\Ketidakhadiran\Models\KetidakhadiranModel;
use Modules\Pegawai\Models\PegawaiModel;
use CodeIgniter\RESTful\ResourceController;

class Ketidakhadiran extends ResourceController
{
    protected $modelName = 'Modules\Ketidakhadiran\Models\KetidakhadiranModel';
    protected $format    = 'json';
    protected $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

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

    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $data = $this->request->getPost();
        $bulan = isset($data['bulan']) ? $data['bulan'] : date('m');
        $tahun = isset($data['tahun']) ? $data['tahun'] : date('Y');

        $ketidakhadiran = $this->model
            ->select('dat_ketidakhadiran.*, mst_pegawai.nama as nama_pegawai')
            ->join('mst_pegawai', 'mst_pegawai.id = dat_ketidakhadiran.id_pegawai')
            ->where('MONTH(tanggal_awal)', $bulan)
            ->where('YEAR(tanggal_awal)', $tahun)
            ->findAll();

        return $this->respond($ketidakhadiran, 200);
    }

    public function show($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $ketidakhadiran = $this->model
            ->select('dat_ketidakhadiran.*, mst_pegawai.nama as nama_pegawai')
            ->join('mst_pegawai', 'mst_pegawai.id = dat_ketidakhadiran.id_pegawai')
            ->where('dat_ketidakhadiran.id', $id)
            ->first();

        if (!$ketidakhadiran) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($ketidakhadiran, 200);
    }

    public function create()
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $data = $this->request->getPost();
        $pegawai = $this->pegawaiModel->find($data['id_pegawai']);
        if (!$pegawai) {
            return $this->failNotFound('ID Pegawai tidak ditemukan.');
        }

        $file = $this->request->getFile('file');
        $fileName = $file && !$file->getError() ? $file->getRandomName() : '';
        if ($fileName) {
            $file->move('uploads/ketidakhadiran', $fileName);
        }

        $this->model->save([
            'id_pegawai' => $data['id_pegawai'],
            'keterangan' => $data['keterangan'],
            'tanggal_awal' => $data['tanggal_awal'],
            'tanggal_akhir' => $data['tanggal_akhir'],
            'deskripsi' => $data['deskripsi'],
            'file' => $fileName,
            'status_pengajuan' => $data['status_pengajuan'],
        ]);

        return $this->respondCreated(['message' => 'Data berhasil disimpan']);
    }

    public function update($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $data = $this->request->getPost();
        $ketidakhadiran = $this->model->find($id);
        if (!$ketidakhadiran) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $file = $this->request->getFile('file');
        $fileName = $file && !$file->getError() ? $file->getRandomName() : '';
        if ($fileName) {
            $file->move('uploads/ketidakhadiran', $fileName);
        }

        $this->model->update($id, [
            'keterangan' => $data['keterangan'],
            'tanggal_awal' => $data['tanggal_awal'],
            'tanggal_akhir' => $data['tanggal_akhir'],
            'deskripsi' => $data['deskripsi'],
            'file' => $fileName,
            'status_pengajuan' => $data['status_pengajuan'],
        ]);

        return $this->respond(['message' => 'Data berhasil diperbarui']);
    }

    public function delete($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $ketidakhadiran = $this->model->find($id);
        if (!$ketidakhadiran) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $filePath = ROOTPATH . 'public/uploads/ketidakhadiran/' . basename($ketidakhadiran['file']);
        if (file_exists($filePath) && !is_dir($filePath)) {
            unlink($filePath);
        }

        $this->model->delete($id);

        return $this->respondDeleted(['message' => 'Data berhasil dihapus']);
    }
}




