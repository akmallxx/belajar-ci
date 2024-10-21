<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PresensiModel;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;

class RekapHarian extends ResourceController
{
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

    // https://domain.com/api/rekap_presensi?date=2024-10-22
    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $presensiModel = new PresensiModel();
        $lokasi_presensi = new LokasiPresensiModel();

        // Get the 'date' parameter from the request
        $tanggal = $this->request->getVar('date');

        // Start query to get attendance data including employee name
        $query = $presensiModel->select('presensi.*, pegawai.nama')
            ->join('pegawai', 'pegawai.id = presensi.id_pegawai');

        // Add where condition only if 'date' is provided
        if ($tanggal) {
            $query->where('tanggal_masuk', $tanggal);
        }

        // Fetch all attendance data
        $rekap_harian = $query->findAll();

        foreach ($rekap_harian as &$rh) {
            $batas_waktu = $this->getBatasWaktu($rh['lokasi_presensi']);
            $rh['status'] = $rh['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
            $rh['keterlambatan'] = $rh['jam_masuk'] ? $this->calculateDelay($rh['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';
            $rh['hari'] = $this->getHari($rh['tanggal_masuk']);
            $rh['lokpres'] = $lokasi_presensi->find($rh['lokasi_presensi']);
        }

        return $this->respond([
            'status' => 200,
            'tanggal' => $tanggal ?: date('Y-m-d'),
            'rekap_harian' => $rekap_harian,
        ]);
    }

    public function store()
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $presensiModel = new PresensiModel();

        // Get POST data
        $data = $this->request->getPost();

        // Insert attendance data
        $presensiModel->insert([
            'id_pegawai' => $data['id_pegawai'],
            'tanggal_masuk' => $data['tanggal_masuk'],
            'jam_masuk' => $data['jam_masuk'],
            'tanggal_keluar' => $data['tanggal_keluar'],
            'jam_keluar' => $data['jam_keluar'],
            'foto_masuk' => $data['foto_masuk'],
            'foto_keluar' => $data['foto_keluar'],
            'durasi' => $this->calculateDuration($data['jam_masuk'], $data['jam_keluar'])
        ]);

        return $this->respondCreated(['message' => 'Data rekap harian berhasil disimpan']);
    }

    public function show($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $presensiModel = new PresensiModel();
        $rekap_harian = $presensiModel->select('presensi.*, pegawai.nip, pegawai.nama, pegawai.lokasi_presensi')
            ->join('pegawai', 'pegawai.id = presensi.id_pegawai')
            ->find($id);

        if (!$rekap_harian) {
            return $this->failNotFound('Data tidak ditemukan atau sudah dihapus');
        }

        $rekap_harian['hari'] = $this->getHari($rekap_harian['tanggal_masuk']);
        $batas_waktu = $this->getBatasWaktu($rekap_harian['lokasi_presensi']);
        $rekap_harian['status'] = $rekap_harian['jam_masuk'] ? 'Hadir' : 'Tidak Hadir';
        $rekap_harian['keterlambatan'] = $rekap_harian['jam_masuk'] ? $this->calculateDelay($rekap_harian['jam_masuk'], $batas_waktu['jam_masuk']) : 'Belum Masuk';

        return $this->respond(['status' => 'success', 'data' => $rekap_harian]);
    }

    public function update($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $presensiModel = new PresensiModel();

        // Get PUT or PATCH data
        $data = $this->request->getRawInput();

        // Update the attendance record
        $presensiModel->update($id, [
            'id_pegawai' => $data['id_pegawai'],
            'jam_masuk' => $data['jam_masuk'],
            'jam_keluar' => $data['jam_keluar'],
            'durasi' => $this->calculateDuration($data['jam_masuk'], $data['jam_keluar'])
        ]);

        return $this->respond(['message' => 'Data rekap harian berhasil diubah']);
    }

    public function delete($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('API key tidak valid');
        }

        $presensiModel = new PresensiModel();
        $rekapHarian = $presensiModel->find($id);

        if ($rekapHarian) {
            $presensiModel->delete($id);
            return $this->respondDeleted(['message' => 'Data rekap harian dan file terkait berhasil dihapus']);
        } else {
            return $this->failNotFound('Data tidak ditemukan atau sudah dihapus');
        }
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
        return $builder->get()->getRowArray();
    }
    
    private function calculateDelay($jam_masuk, $batas_masuk)
    {
        $jam_masuk_dt = new \DateTime($jam_masuk);
        $batas_masuk_dt = new \DateTime($batas_masuk);
    
        if ($jam_masuk_dt > $batas_masuk_dt) {
            $interval = $jam_masuk_dt->diff($batas_masuk_dt);
            return 'Terlambat ' . $interval->h . ' jam ' . $interval->i . ' menit';
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
}
