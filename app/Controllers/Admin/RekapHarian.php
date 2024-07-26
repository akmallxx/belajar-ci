<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use App\Models\PegawaiModel;

class RekapHarian extends BaseController
{
    public function index()
    {
        $presensiModel = new PresensiModel();
        $tanggal = $this->request->getGet('tanggal') ?: date('Y-m-d'); // Ambil tanggal dari parameter GET atau gunakan tanggal hari ini

        $rekap_harian = $presensiModel->select('presensi.*, pegawai.nama, pegawai.lokasi_presensi')
            ->join('pegawai', 'pegawai.id = presensi.id_pegawai')
            ->where('tanggal_masuk', $tanggal)
            ->findAll();

        foreach ($rekap_harian as &$rh) {
            $batas_waktu = $this->getBatasWaktu($rh['lokasi_presensi']);
            $rh['status'] = $rh['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
            $rh['keterlambatan'] = $rh['jam_masuk'] ? $this->calculateDelay($rh['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';
            $rh['hari'] = $this->getHari($rh['tanggal_masuk']);
        }

        $data = [
            'title' => 'Data Presensi Harian',
            'rekap_harian' => $rekap_harian,
            'tanggal' => $tanggal // Kirimkan tanggal ke view
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

    private function getBatasWaktu($id_lokasi)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lokasi_presensi');
        $builder->select('jam_masuk, jam_pulang');
        $builder->where('id', $id_lokasi);
        $query = $builder->get();
        return $query->getRowArray();
    }

    private function calculateDelay($jam_masuk, $batas_masuk)
    {
        $jam_masuk_dt = new \DateTime($jam_masuk);
        $batas_masuk_dt = new \DateTime($batas_masuk);

        if ($jam_masuk_dt > $batas_masuk_dt) {
            $interval = $jam_masuk_dt->diff($batas_masuk_dt);
            return $interval->format('Terlambat %h jam %i menit');
        } else {
            return 'Tepat Waktu';
        }
    }

    private function calculateDuration($jam_masuk, $jam_keluar)
    {
        $jam_masuk_dt = new \DateTime($jam_masuk);
        $jam_keluar_dt = new \DateTime($jam_keluar);

        $interval = $jam_masuk_dt->diff($jam_keluar_dt);

        return $interval->format('%h jam %i menit');
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
        $presensiModel = new PresensiModel();
        $presensiModel->insert([
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'foto_masuk' => $this->request->getPost('foto_masuk'), // Pastikan ini diupdate dengan file upload jika diperlukan
            'foto_keluar' => $this->request->getPost('foto_keluar'), // Pastikan ini diupdate dengan file upload jika diperlukan
            'durasi' => $this->calculateDuration(
                $this->request->getPost('jam_masuk'),
                $this->request->getPost('jam_keluar')
            )
        ]);
        session()->setFlashData('success', 'Data rekap harian berhasil disimpan');

        return redirect()->to(base_url('admin/rekap_harian'));
    }

    public function detail($id)
    {
        $presensiModel = new PresensiModel();
        $rekap_harian = $presensiModel->select('presensi.*, pegawai.nip, pegawai.nama, pegawai.lokasi_presensi') // Pastikan nip diambil
            ->join('pegawai', 'pegawai.id = presensi.id_pegawai')
            ->find($id);

        if (!$rekap_harian) {
            session()->setFlashData('error', 'Data tidak ditemukan atau sudah dihapus');
            return redirect()->to(base_url('admin/rekap_harian'));
        }

        // Tambahkan hari dan status
        $rekap_harian['hari'] = $this->getHari($rekap_harian['tanggal_masuk']);
        $batas_waktu = $this->getBatasWaktu($rekap_harian['lokasi_presensi']);
        $rekap_harian['status'] = $rekap_harian['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
        $rekap_harian['keterlambatan'] = $rekap_harian['jam_masuk'] ? $this->calculateDelay($rekap_harian['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';

        // Data yang dikirim ke view
        $data = [
            'title' => 'Detail Rekap Harian',
            'rekap_harian' => $rekap_harian
        ];
        return view('admin/rekap_harian/detail', $data);
    }

    public function edit($id)
    {
        $presensiModel = new PresensiModel();
        $pegawaiModel = new PegawaiModel();

        $rekap_harian = $presensiModel->find($id);
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
        $presensiModel = new PresensiModel();
        $presensiModel->update($id, [
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'foto_masuk' => $this->request->getPost('foto_masuk'), // Pastikan ini diupdate dengan file upload jika diperlukan
            'foto_keluar' => $this->request->getPost('foto_keluar'), // Pastikan ini diupdate dengan file upload jika diperlukan
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
        $presensiModel = new PresensiModel();
        $rekapHarian = $presensiModel->find($id);

        if ($rekapHarian) {
            // Tentukan path file
            $uploadDir = ROOTPATH . 'public/uploads/';
            $fotoMasukFile = basename($rekapHarian['foto_masuk']);
            $fotoKeluarFile = basename($rekapHarian['foto_keluar']);
            $fotoMasukPath = $uploadDir . $fotoMasukFile;
            $fotoKeluarPath = $uploadDir . $fotoKeluarFile;

            // Hapus file jika ada
            if (file_exists($fotoMasukPath) && !is_dir($fotoMasukPath)) {
                unlink($fotoMasukPath);
            }
            if (file_exists($fotoKeluarPath) && !is_dir($fotoKeluarPath)) {
                unlink($fotoKeluarPath);
            }

            // Hapus data dari database
            $presensiModel->delete($id);
            session()->setFlashData('success', 'Data rekap harian dan file terkait berhasil dihapus');
        } else {
            session()->setFlashData('error', 'Data tidak ditemukan atau sudah dihapus');
        }

        return redirect()->to(base_url('admin/rekap_harian'));
    }
}
