<?php

namespace App\Controllers\Api;

use App\Models\KetidakhadiranModel;
use App\Models\PegawaiModel;
use CodeIgniter\RESTful\ResourceController;

class Ketidakhadiran extends ResourceController
{
    protected $modelName = 'App\Models\KetidakhadiranModel';
    protected $format    = 'json';

    protected $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function index()
    {
        $data = $this->request->getJSON(true);

        $bulan = isset($data['bulan']) ? $data['bulan'] : date('m');
        $tahun = isset($data['tahun']) ? $data['tahun'] : date('Y');

        $ketidakhadiran = $this->model
            ->select('ketidakhadiran.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id = ketidakhadiran.id_pegawai')
            ->where('MONTH(tanggal_awal)', $bulan)
            ->where('YEAR(tanggal_awal)', $tahun)
            ->findAll();

        return $this->respond($ketidakhadiran, 200);
    }

    public function show($id = null)
    {
        $ketidakhadiran = $this->model
            ->select('ketidakhadiran.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id = ketidakhadiran.id_pegawai')
            ->where('ketidakhadiran.id', $id)
            ->first();

        if (!$ketidakhadiran) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($ketidakhadiran, 200);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

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
        $data = $this->request->getJSON(true);

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

    public function statuses($id, $status)
    {
        $ketidakhadiran = $this->model->find($id);
        if (!$ketidakhadiran) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $this->model->update($id, [
            'status_pengajuan' => ($status == 'disetujui') ? 'disetujui' : 'ditolak'
        ]);

        return $this->respond(['message' => 'Status pengajuan berhasil diperbarui']);
    }
}
