<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use App\Models\PegawaiModel;

class RekapBulanan extends BaseController
{
    public function index()
    {
        $PresensiModel = new PresensiModel();
        $PegawaiModel = new PegawaiModel();

        $query = $PresensiModel->select('
                pegawai.nip as nip_pegawai, 
                pegawai.nama as nama_pegawai,
                presensi.jam_masuk,
                presensi.jam_keluar')
            ->join('pegawai', 'pegawai.id = presensi.id_pegawai', 'left')
            ->get();

        $presensi_records = $query->getResultArray();

        $rekap_bulanan = [];

        foreach ($presensi_records as $record) {
            $lateness = $this->calculateLateness($record['jam_masuk'], $record['jam_keluar']);
            $hours_worked = $this->calculateHoursWorked($record['jam_masuk'], $record['jam_keluar']);

            if (!isset($rekap_bulanan[$record['nip_pegawai']])) {
                $rekap_bulanan[$record['nip_pegawai']] = [
                    'nip_pegawai' => $record['nip_pegawai'],
                    'nama_pegawai' => $record['nama_pegawai'],
                    'jumlah_kehadiran' => 0,
                    'total_lateness' => 0,
                    'total_hours_worked' => 0
                ];
            }

            $rekap_bulanan[$record['nip_pegawai']]['jumlah_kehadiran']++;
            $rekap_bulanan[$record['nip_pegawai']]['total_lateness'] += $lateness;
            $rekap_bulanan[$record['nip_pegawai']]['total_hours_worked'] += $hours_worked;
        }

        foreach ($rekap_bulanan as &$employee) {
            $employee['total_lateness'] = gmdate('H:i:s', $employee['total_lateness']);
            $employee['total_hours_worked'] = gmdate('H:i:s', $employee['total_hours_worked']);
        }

        $data = [
            'title' => 'Data Rekap Bulanan',
            'rekap_bulanan' => $rekap_bulanan
        ];

        return view('admin/rekap_bulanan/rekap_bulanan', $data);
    }

    private function calculateLateness($jam_masuk, $jam_keluar)
    {
        $expected_start = new \DateTime('09:00:00');
        $expected_end = new \DateTime('16:00:00');

        $actual_start = new \DateTime($jam_masuk);
        $actual_end = new \DateTime($jam_keluar);

        $lateness_start = max(0, $actual_start->getTimestamp() - $expected_start->getTimestamp());
        $lateness_end = max(0, $expected_end->getTimestamp() - $actual_end->getTimestamp());

        return $lateness_start + $lateness_end;
    }

    private function calculateHoursWorked($jam_masuk, $jam_keluar)
    {
        $actual_start = new \DateTime($jam_masuk);
        $actual_end = new \DateTime($jam_keluar);

        $hours_worked = $actual_end->getTimestamp() - $actual_start->getTimestamp();
        return max(0, $hours_worked); 
    }
}
