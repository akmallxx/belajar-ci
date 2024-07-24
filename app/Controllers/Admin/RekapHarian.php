<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RekapHarianModel;
use App\Models\PegawaiModel;

class RekapHarian extends BaseController
{
    public function index()
    {
        $rekapHarianModel = new RekapHarianModel();
        $tanggal = date('Y-m-d'); // Ambil tanggal hari ini

        $rekap_harian = $rekapHarianModel->getRekapHarian($tanggal);

        // Tambahkan status berdasarkan kehadiran dan keterlambatan, serta hari
        foreach ($rekap_harian as &$rh) {
            $batas_waktu = $rekapHarianModel->getBatasWaktu($rh['lokasi_presensi']);
            $rh['status'] = $rh['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
            $rh['keterlambatan'] = $rh['jam_masuk'] ? $rekapHarianModel->calculateDelay($rh['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';
            $rh['hari'] = $this->getHari($rh['tanggal_masuk']);
        }

        $data = [
            'title' => 'Rekap Harian',
            'rekap_harian' => $rekap_harian
        ];
        return view('admin/rekap_harian/rekap_harian', $data);
    }

    private function getHari($tanggal)
    {
        $hari = date('l', strtotime($tanggal));
        $daftar_hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        return $daftar_hari[$hari];
    }

    public function create()
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Tambah Rekap Harian',
            'pegawai' => $pegawaiModel->findAll()
        ];
        return view('admin/rekap_harian/create', $data);
    }

    public function store()
    {
        $rekapHarianModel = new RekapHarianModel();
        $rekapHarianModel->insert([
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'durasi' => $this->calculateDuration(
                $this->request->getPost('jam_masuk'),
                $this->request->getPost('jam_keluar')
            )
        ]);
        session()->setFlashData('success', 'Data rekap harian berhasil disimpan');

        return redirect()->to(base_url('admin/rekap_harian'));
    }

    public function edit($id)
    {
        $rekapHarianModel = new RekapHarianModel();
        $pegawaiModel = new PegawaiModel();

        $rekap_harian = $rekapHarianModel->find($id);
        if ($rekap_harian) {
            // Ambil informasi pegawai
            $pegawai = $pegawaiModel->find($rekap_harian['id_pegawai']);
            $rekap_harian['nama'] = $pegawai['nama'];

            $data = [
                'title' => 'Edit Rekap Harian',
                'rekap_harian' => $rekap_harian,
                'pegawai' => $pegawaiModel->findAll()
            ];
            return view('admin/rekap_harian/edit', $data);
        } else {
            // Jika data tidak ditemukan, kembalikan dengan pesan error
            session()->setFlashData('error', 'Data tidak ditemukan atau sudah dihapus');
            return redirect()->to(base_url('admin/rekap_harian'));
        }
    }


    public function update($id)
    {
        $rekapHarianModel = new RekapHarianModel();
        $rekapHarianModel->update($id, [
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'durasi' => $this->calculateDuration(
                $this->request->getPost('jam_masuk'),
                $this->request->getPost('jam_keluar')
            )
        ]);
        session()->setFlashData('success', 'Data rekap harian berhasil diubah');

        return redirect()->to(base_url('admin/rekap_harian'));
    }

    public function delete($id)
    {
        $rekapHarianModel = new RekapHarianModel();
        $rekapHarian = $rekapHarianModel->find($id);
        if ($rekapHarian) {
            $rekapHarianModel->delete($id);
            session()->setFlashData('success', 'Data rekap harian berhasil dihapus');
        }

        return redirect()->to(base_url('admin/rekap_harian'));
    }

    private function calculateDuration($jamMasuk, $jamKeluar)
    {
        $masuk = strtotime($jamMasuk);
        $keluar = strtotime($jamKeluar);
        return $keluar - $masuk;
    }
}
