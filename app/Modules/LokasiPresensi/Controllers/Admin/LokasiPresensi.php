<?php

namespace Modules\LokasiPresensi\Controllers\Admin;

use App\Controllers\BaseController;
use Modules\LokasiPresensi\Models\LokasiPresensiModel;

class LokasiPresensi extends BaseController
{
    public function index()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Data Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->findAll()
        ];
        return view('Modules\LokasiPresensi\Views\admin\lokasi_presensi', $data);
    }

    public function detail($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Detail Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->find($id)
        ];
        return view('Modules\LokasiPresensi\Views\admin\detail', $data);
    }

    public function form($id = null)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => $id ? 'Edit Lokasi Presensi' : 'Tambah Lokasi Presensi',
            'lokasi_presensi' => $id ? $LokasiPresensiModel->find($id) : null
        ];
        return view('Modules\LokasiPresensi\Views\admin\form', $data);
    }

    public function save($id = null)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $saveData = [
            'nama_lokasi'   => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi'   => $this->request->getPost('tipe_lokasi'),
            'latitude'      => $this->request->getPost('latitude'),
            'longitude'     => $this->request->getPost('longitude'),
            'radius'        => $this->request->getPost('radius'),
            'zona_waktu'    => $this->request->getPost('zona_waktu'),
            'jam_masuk'     => $this->request->getPost('jam_masuk'),
            'jam_pulang'    => $this->request->getPost('jam_pulang')
        ];

        if ($id) {
            $saveData['id'] = $id;
        }

        $LokasiPresensiModel->save($saveData);
        session()->setFlashData('success', 'Data lokasi presensi berhasil disimpan');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

    public function delete($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $lokasi_presensi = $LokasiPresensiModel->find($id);
        if ($lokasi_presensi) {
            $LokasiPresensiModel->delete($id);
            session()->setFlashData('success', 'Data lokasi presensi berhasil dihapus');
        }
        return redirect()->to(base_url('admin/lokasi_presensi'));
    }
}
