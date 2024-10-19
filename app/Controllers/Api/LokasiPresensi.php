<?php

namespace App\Controllers\Api;

use App\Models\LokasiPresensiModel;
use CodeIgniter\RESTful\ResourceController;

class LokasiPresensi extends ResourceController
{
    protected $modelName = 'App\Models\LokasiPresensiModel';
    protected $format    = 'json';

    // GET /lokasi_presensi
    public function index()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->findAll();

        return $this->respond([
            'status' => 200,
            'message' => 'Data lokasi presensi berhasil diambil',
            'data' => $lokasiPresensi
        ]);
    }

    // GET /lokasi_presensi/{id}
    public function show($id = null)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->find($id);

        if (!$lokasiPresensi) {
            return $this->failNotFound('Data lokasi presensi tidak ditemukan');
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Detail lokasi presensi berhasil diambil',
            'data' => $lokasiPresensi
        ]);
    }

    // POST /lokasi_presensi
    public function create()
    {
        $data = $this->request->getJSON(true);

        $LokasiPresensiModel = new LokasiPresensiModel();
        $LokasiPresensiModel->insert([
            'nama_lokasi' => $data['nama_lokasi'],
            'alamat_lokasi' => $data['alamat_lokasi'],
            'tipe_lokasi' => $data['tipe_lokasi'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'radius' => $data['radius'],
            'zona_waktu' => $data['zona_waktu'],
            'jam_masuk' => $data['jam_masuk'],
            'jam_pulang' => $data['jam_pulang'],
        ]);

        return $this->respondCreated([
            'status' => 201,
            'message' => 'Data lokasi presensi berhasil disimpan'
        ]);
    }

    // PUT /lokasi_presensi/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->find($id);

        if (!$lokasiPresensi) {
            return $this->failNotFound('Data lokasi presensi tidak ditemukan');
        }

        $LokasiPresensiModel->update($id, [
            'nama_lokasi' => $data['nama_lokasi'],
            'alamat_lokasi' => $data['alamat_lokasi'],
            'tipe_lokasi' => $data['tipe_lokasi'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'radius' => $data['radius'],
            'zona_waktu' => $data['zona_waktu'],
            'jam_masuk' => $data['jam_masuk'],
            'jam_pulang' => $data['jam_pulang'],
        ]);

        return $this->respond([
            'status' => 200,
            'message' => 'Data lokasi presensi berhasil diubah'
        ]);
    }

    // DELETE /lokasi_presensi/{id}
    public function delete($id = null)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasiPresensi = $LokasiPresensiModel->find($id);

        if (!$lokasiPresensi) {
            return $this->failNotFound('Data lokasi presensi tidak ditemukan');
        }

        $LokasiPresensiModel->delete($id);

        return $this->respondDeleted([
            'status' => 200,
            'message' => 'Data lokasi presensi berhasil dihapus'
        ]);
    }
}
