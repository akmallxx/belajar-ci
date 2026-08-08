<?php

namespace Modules\Presensi\Controllers\Admin;

use App\Controllers\BaseController;
use Modules\Presensi\Models\PresensiModel;
use Modules\Pegawai\Models\PegawaiModel;
use Modules\LokasiPresensi\Models\LokasiPresensiModel;
use Modules\Ketidakhadiran\Models\KetidakhadiranModel;

class RekapBulanan extends BaseController
{
    public function index()
    {
        $PresensiModel = new PresensiModel();
        $PegawaiModel = new PegawaiModel();
        $LokasiPresensiModel = new LokasiPresensiModel();
        $KetidakhadiranModel = new KetidakhadiranModel();

        $selected_month = $this->request->getGet('month');
        $selected_year = $this->request->getGet('year');

        $presensiQuery = $PresensiModel->select('
            dat_presensi.id as presensi_id,
            dat_presensi.tanggal_masuk, 
            dat_presensi.jam_masuk, 
            dat_presensi.tanggal_keluar, 
            dat_presensi.jam_keluar,
            mst_pegawai.id as id_pegawai,
            mst_pegawai.nama as nama_pegawai, 
            mst_pegawai.nip as nip_pegawai,
            mst_lokasi_presensi.jam_masuk as jam_masuk_lokasi,
            mst_lokasi_presensi.jam_pulang as jam_pulang_lokasi
        ')
        ->join('mst_pegawai', 'mst_pegawai.id = dat_presensi.id_pegawai', 'left')
        ->join('mst_lokasi_presensi', 'mst_lokasi_presensi.id = mst_pegawai.lokasi_presensi', 'left');

        if ($selected_month && $selected_year) {
            $presensiQuery->where('MONTH(dat_presensi.tanggal_masuk)', $selected_month)
                          ->where('YEAR(dat_presensi.tanggal_masuk)', $selected_year);
        } elseif ($selected_year) {
            $presensiQuery->where('YEAR(dat_presensi.tanggal_masuk)', $selected_year);
        }

        $presensi_records = $presensiQuery->findAll();

        $rekap_bulanan = [];

        foreach ($presensi_records as $record) {
            $jam_masuk_lokasi = $record['jam_masuk_lokasi'];
            $jam_pulang_lokasi = $record['jam_pulang_lokasi'];

            $jam_masuk = strtotime($record['jam_masuk']);
            $jam_keluar = strtotime($record['jam_keluar']);
            $jam_masuk_lokasi = strtotime($jam_masuk_lokasi);
            $jam_pulang_lokasi = strtotime($jam_pulang_lokasi);

            $lateness = 0;
            $hours_worked = 0;

            if ($jam_masuk > $jam_masuk_lokasi) {
                $lateness = $jam_masuk - $jam_masuk_lokasi;
            }

            if ($jam_keluar > $jam_pulang_lokasi) {
                $hours_worked = $jam_keluar - $jam_masuk;
            }

            $absences = $KetidakhadiranModel->where('id_pegawai', $record['id_pegawai'])
                                             ->countAllResults();

            if (!isset($rekap_bulanan[$record['nip_pegawai']])) {
                $rekap_bulanan[$record['nip_pegawai']] = [
                    'nip_pegawai' => $record['nip_pegawai'],
                    'nama_pegawai' => $record['nama_pegawai'],
                    'jumlah_kehadiran' => 0,
                    'total_lateness' => 0,
                    'total_hours_worked' => 0,
                    'total_absences' => 0,
                ];
            }

            $rekap_bulanan[$record['nip_pegawai']]['jumlah_kehadiran']++;
            $rekap_bulanan[$record['nip_pegawai']]['total_lateness'] += $lateness;
            $rekap_bulanan[$record['nip_pegawai']]['total_hours_worked'] += $hours_worked;
            $rekap_bulanan[$record['nip_pegawai']]['total_absences'] = $absences;
        }

        $data = [
            'title' => 'Data Rekap Bulanan',
            'rekap_bulanan' => $rekap_bulanan,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
        ];

        return view('Modules\Presensi\Views\admin\rekap_bulanan\rekap_bulanan', $data);
    }

    public function exportToCSV()
    {
        $PresensiModel = new PresensiModel();
        $KetidakhadiranModel = new KetidakhadiranModel();

        $selected_month = $this->request->getGet('month');
        $selected_year = $this->request->getGet('year');

        $presensiQuery = $PresensiModel->select('
            dat_presensi.id as presensi_id,
            dat_presensi.tanggal_masuk, 
            dat_presensi.jam_masuk, 
            dat_presensi.tanggal_keluar, 
            dat_presensi.jam_keluar,
            mst_pegawai.id as id_pegawai,
            mst_pegawai.nama as nama_pegawai, 
            mst_pegawai.nip as nip_pegawai,
            mst_lokasi_presensi.jam_masuk as jam_masuk_lokasi,
            mst_lokasi_presensi.jam_pulang as jam_pulang_lokasi
        ')
        ->join('mst_pegawai', 'mst_pegawai.id = dat_presensi.id_pegawai', 'left')
        ->join('mst_lokasi_presensi', 'mst_lokasi_presensi.id = mst_pegawai.lokasi_presensi', 'left');

        if ($selected_month && $selected_year) {
            $presensiQuery->where('MONTH(dat_presensi.tanggal_masuk)', $selected_month)
                          ->where('YEAR(dat_presensi.tanggal_masuk)', $selected_year);
        } elseif ($selected_year) {
            $presensiQuery->where('YEAR(dat_presensi.tanggal_masuk)', $selected_year);
        }

        $presensi_records = $presensiQuery->findAll();

        $rekap_bulanan = [];

        foreach ($presensi_records as $record) {
            $jam_masuk_lokasi = $record['jam_masuk_lokasi'];
            $jam_pulang_lokasi = $record['jam_pulang_lokasi'];

            $jam_masuk = strtotime($record['jam_masuk']);
            $jam_keluar = strtotime($record['jam_keluar']);
            $jam_masuk_lokasi = strtotime($jam_masuk_lokasi);
            $jam_pulang_lokasi = strtotime($jam_pulang_lokasi);

            $lateness = 0;
            $hours_worked = 0;

            if ($jam_masuk > $jam_masuk_lokasi) {
                $lateness = $jam_masuk - $jam_masuk_lokasi;
            }

            if ($jam_keluar > $jam_pulang_lokasi) {
                $hours_worked = $jam_keluar - $jam_masuk;
            }

            $absences = $KetidakhadiranModel->where('id_pegawai', $record['id_pegawai'])
                                             ->countAllResults();

            if (!isset($rekap_bulanan[$record['nip_pegawai']])) {
                $rekap_bulanan[$record['nip_pegawai']] = [
                    'nip_pegawai' => $record['nip_pegawai'],
                    'nama_pegawai' => $record['nama_pegawai'],
                    'jumlah_kehadiran' => 0,
                    'total_lateness' => 0,
                    'total_hours_worked' => 0,
                    'total_absences' => 0,
                ];
            }

            $rekap_bulanan[$record['nip_pegawai']]['jumlah_kehadiran']++;
            $rekap_bulanan[$record['nip_pegawai']]['total_lateness'] += $lateness;
            $rekap_bulanan[$record['nip_pegawai']]['total_hours_worked'] += $hours_worked;
            $rekap_bulanan[$record['nip_pegawai']]['total_absences'] = $absences;
        }

        $csv_data = [];
        $csv_data[] = ['NIP Pegawai', 'Nama Pegawai', 'Jumlah Kehadiran', 'Total Keterlambatan', 'Total Jam Kerja', 'Total Ketidakhadiran'];

        foreach ($rekap_bulanan as $rb) {
            $csv_data[] = [
                $rb['nip_pegawai'],
                $rb['nama_pegawai'],
                $rb['jumlah_kehadiran'],
                gmdate('H:i:s', $rb['total_lateness']),
                gmdate('H:i:s', $rb['total_hours_worked']),
                $rb['total_absences']
            ];
        }

        $filename = "rekap_bulanan" . ($selected_month && $selected_year ? "{$selected_month}{$selected_year}" : ($selected_year ? "_{$selected_year}" : "")) . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);
        $output = fopen('php://output', 'w');

        foreach ($csv_data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }
}






