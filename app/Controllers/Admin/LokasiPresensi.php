<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;

class LokasiPresensi extends BaseController
{
    public function index()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Data Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->findAll()
        ];
        return view('admin/lokasi_presensi/lokasi_presensi', $data);
    }

    public function detail($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Detail Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->find($id)
        ];
        return view('admin/lokasi_presensi/detail', $data);
    }


    public function create()
    {
        $data = [
            'title' => 'Tambah Lokasi Presensi',
        ];
        return view('admin/lokasi_presensi/create', $data);
    }

    public function store()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $LokasiPresensiModel->insert([
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi' => $this->request->getPost('tipe_lokasi'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'radius' => $this->request->getPost('radius'),
            'zona_waktu' => $this->request->getPost('zona_waktu'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_pulang' => $this->request->getPost('jam_pulang')
        ]);
        session()->setFlashData('success', 'Data lokasi presensi berhasil disimpan');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

    public function edit($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Edit lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->find($id)
        ];
        return view('admin/lokasi_presensi/edit', $data);
    }

    public function update($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $LokasiPresensiModel->update($id, [
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi' => $this->request->getPost('tipe_lokasi'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'radius' => $this->request->getPost('radius'),
            'zona_waktu' => $this->request->getPost('zona_waktu'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_pulang' => $this->request->getPost('jam_pulang')
        ]);
        session()->setFlashData('success', 'Data lokasi presensi berhasil diubah');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

    public function delete($id) {
        $LokasiPresensiModel = new LokasiPresensiModel();

        $lokasi_presensi = $LokasiPresensiModel->find($id);
        if ($lokasi_presensi) {
            $LokasiPresensiModel->delete($id);
            session()->setFlashData('success', 'Data lokasi presensi berhasil dihapus');

            return redirect()->to(base_url('admin/lokasi_presensi'));
        }
    }
}
