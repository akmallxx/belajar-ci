<?php

namespace Modules\Presensi\Controllers\Admin;

use App\Controllers\BaseController;
use Modules\Presensi\Models\PresensiModel;
use Modules\LokasiPresensi\Models\LokasiPresensiModel;
use Modules\Pegawai\Models\PegawaiModel;

class RekapHarian extends BaseController
{
    public function index()
    {
        $presensiModel = new PresensiModel();
        $lokasi_presensi = new LokasiPresensiModel();
        $tanggal = $this->request->getGet('tanggal') ?: date('Y-m-d');

        $rekap_harian = $presensiModel->select('dat_presensi.*, mst_pegawai.nama')
            ->join('mst_pegawai', 'mst_pegawai.id = dat_presensi.id_pegawai')
            ->where('tanggal_masuk', $tanggal)
            ->findAll();

        foreach ($rekap_harian as &$rh) {
            $batas_waktu = $this->getBatasWaktu($rh['lokasi_presensi']);
            $rh['status'] = $rh['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
            $rh['keterlambatan'] = $rh['jam_masuk'] ? $this->calculateDelay($rh['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';
            $rh['hari'] = $this->getHari($rh['tanggal_masuk']);
            $rh['lokpres'] = $lokasi_presensi->find($rh['lokasi_presensi']);
        }

        $data = [
            'title' => 'Data Presensi Harian',
            'rekap_harian' => $rekap_harian,
            'tanggal' => $tanggal
        ];

        return view('Modules\Presensi\Views\admin\rekap_harian\rekap_harian', $data);
    }

    private function getHari($tanggal)
    {
        $hari = date('l', strtotime($tanggal));
        $daftar_hari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        return $daftar_hari[$hari];
    }

    private function getBatasWaktu($id_lokasi)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mst_lokasi_presensi');
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
            $jam = $interval->h;
            $menit = $interval->i;
            $result = '';
            if ($jam > 0) { $result .= $jam . ' jam '; }
            if ($menit > 0 || $jam > 0) { $result .= $menit . ' menit'; }
            return 'Terlambat ' . $result;
        } else {
            return 'Tepat Waktu';
        }
    }

    private function calculateDuration($jam_masuk, $jam_keluar)
    {
        if (!$jam_masuk || !$jam_keluar) return '';
        $jam_masuk_dt = new \DateTime($jam_masuk);
        $jam_keluar_dt = new \DateTime($jam_keluar);
        $interval = $jam_masuk_dt->diff($jam_keluar_dt);
        return $interval->format('%h jam %i menit');
    }

    public function form($id = null)
    {
        $presensiModel = new PresensiModel();
        $pegawaiModel = new PegawaiModel();

        $rekap_harian = $id ? $presensiModel->find($id) : null;
        $data = [
            'title' => $id ? 'Edit Rekap Harian' : 'Tambah Rekap Harian',
            'rekap_harian' => $rekap_harian,
            'pegawai' => $pegawaiModel->findAll()
        ];
        return view('Modules\Presensi\Views\admin\rekap_harian\form', $data);
    }

    public function save($id = null)
    {
        $presensiModel = new PresensiModel();
        $id_pegawai = $this->request->getPost('id_pegawai');
        $jam_masuk = $this->request->getPost('jam_masuk');
        $jam_keluar = $this->request->getPost('jam_keluar');

        $saveData = [
            'id_pegawai'    => $id_pegawai,
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jam_masuk'     => $jam_masuk,
            'tanggal_keluar'=> $this->request->getPost('tanggal_keluar'),
            'jam_keluar'    => $jam_keluar,
            'durasi'        => $this->calculateDuration($jam_masuk, $jam_keluar)
        ];

        if ($id) {
            $saveData['id'] = $id;
        }

        $presensiModel->save($saveData);
        session()->setFlashData('success', 'Data rekap harian berhasil disimpan');

        return redirect()->to(base_url('admin/rekap_harian'));
    }

    public function detail($id)
    {
        $presensiModel = new PresensiModel();
        $rekap_harian = $presensiModel->select('dat_presensi.*, mst_pegawai.nip, mst_pegawai.nama, mst_pegawai.lokasi_presensi')
            ->join('mst_pegawai', 'mst_pegawai.id = dat_presensi.id_pegawai')
            ->find($id);

        if (!$rekap_harian) {
            session()->setFlashData('error', 'Data tidak ditemukan atau sudah dihapus');
            return redirect()->to(base_url('admin/rekap_harian'));
        }

        $rekap_harian['hari'] = $this->getHari($rekap_harian['tanggal_masuk']);
        $batas_waktu = $this->getBatasWaktu($rekap_harian['lokasi_presensi']);
        $rekap_harian['status'] = $rekap_harian['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
        $rekap_harian['keterlambatan'] = $rekap_harian['jam_masuk'] ? $this->calculateDelay($rekap_harian['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';

        $data = [
            'title' => 'Detail Rekap Harian',
            'rekap_harian' => $rekap_harian
        ];
        return view('Modules\Presensi\Views\admin\rekap_harian\detail', $data);
    }

    public function delete($id)
    {
        $presensiModel = new PresensiModel();
        $rekapHarian = $presensiModel->find($id);

        if ($rekapHarian) {
            $uploadDir = ROOTPATH . 'public/uploads/';
            $fotoMasukFile = basename($rekapHarian['foto_masuk'] ?? '');
            $fotoKeluarFile = basename($rekapHarian['foto_keluar'] ?? '');
            $fotoMasukPath = $uploadDir . $fotoMasukFile;
            $fotoKeluarPath = $uploadDir . $fotoKeluarFile;

            if ($fotoMasukFile && file_exists($fotoMasukPath) && !is_dir($fotoMasukPath)) {
                unlink($fotoMasukPath);
            }
            if ($fotoKeluarFile && file_exists($fotoKeluarPath) && !is_dir($fotoKeluarPath)) {
                unlink($fotoKeluarPath);
            }

            $presensiModel->delete($id);
            session()->setFlashData('success', 'Data rekap harian berhasil dihapus');
        }

        return redirect()->to(base_url('admin/rekap_harian'));
    }
}
