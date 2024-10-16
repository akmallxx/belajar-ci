<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use App\Models\PegawaiModel;
use App\Models\LokasiPresensiModel;

class RekapPresensi extends BaseController
{
    protected $presensiModel;
    protected $pegawaiModel;
    protected $lokasiPresensiModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->lokasiPresensiModel = new LokasiPresensiModel();
    }

    public function index()
    {
        // Ambil bulan dan tahun dari query string, atau default ke bulan dan tahun saat ini
        $bulan = $this->request->getGet('bulan') ?: date('m');
        $tahun = $this->request->getGet('tahun') ?: date('Y');
        $pegawai_id = session()->get('id_pegawai');

        // Pastikan bulan dan tahun valid
        if (!checkdate($bulan, 1, $tahun)) {
            $bulan = date('m');
            $tahun = date('Y');
        }

        // Hitung tanggal awal dan akhir bulan
        $tanggal_awal = "$tahun-$bulan-01";
        $tanggal_akhir = date("Y-m-t", strtotime($tanggal_awal)); // Mendapatkan tanggal akhir bulan

        // Ambil data presensi dengan join pegawai
        $presensiData = $this->presensiModel
            ->select('presensi.*, pegawai.nip, pegawai.nama')
            ->join('pegawai', 'pegawai.id = presensi.id_pegawai')
            ->where('presensi.id_pegawai', $pegawai_id)
            ->where('tanggal_masuk >=', $tanggal_awal)
            ->where('tanggal_masuk <=', $tanggal_akhir)
            ->findAll();

        // Mengolah data untuk menghitung status dan keterlambatan
        $rekap_presensi = [];
        foreach ($presensiData as $data) {
            $status = 'Izin'; // Default status
            $keterlambatan = ''; // Contoh logika keterlambatan

            // Misalkan kita hitung keterlambatan berdasarkan jam masuk dan jam yang seharusnya
            $pegawai = $this->pegawaiModel->find($pegawai_id);
            $jam_masuk = $this->lokasiPresensiModel->where('id', $pegawai['lokasi_presensi'])->findAll();
            $jamSeharusnya = $jam_masuk[0]['jam_masuk'];
            if ($data['jam_masuk']) {
                if ($data['jam_masuk'] <= $jamSeharusnya) {
                    $status = 'Tepat Waktu';
                } else {
                    $status = 'Terlambat';
                    $keterlambatan = $this->calculateDelay($data['jam_masuk'], $jamSeharusnya);
                }
            } else {
                // Jika tidak ada data jam_masuk, anggap sebagai ijin
                $status = 'Izin';
            }

            $rekap_presensi[] = [
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'tanggal_masuk' => date('d M', strtotime($data['tanggal_masuk'])), // Hanya tampilkan tanggal dalam format hari bulan
                'hari' => $this->getHari($data['tanggal_masuk']),
                'jam_masuk' => $data['jam_masuk'],
                'jam_keluar' => $data['jam_keluar'],
                'status' => $status,
                'keterlambatan' => $keterlambatan,
            ];
        }

        $data = [
            'title' => 'Rekap Presensi',
            'rekap_presensi' => $rekap_presensi,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ];

        return view('pegawai/rekap_presensi', $data);
    }

    private function calculateDelay($jamMasuk, $jamSeharusnya)
    {
        $jamMasuk = new \DateTime($jamMasuk);
        $jamSeharusnya = new \DateTime($jamSeharusnya);
        $interval = $jamSeharusnya->diff($jamMasuk);
        return $interval->format('%h jam %i menit');
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
}
