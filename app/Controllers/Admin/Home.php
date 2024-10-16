<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\PresensiModel;
use App\Models\PegawaiModel;
use App\Models\LokasiPresensiModel;
use App\Models\KetidakhadiranModel;


class Home extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $presensiModel = new PresensiModel();
        $pegawaiModel = new PegawaiModel();
        $lokasiPresensiModel = new LokasiPresensiModel();
        $ketidakhadiranModel = new KetidakhadiranModel();
        
        
        $pegawaiList = $pegawaiModel->findAll(); // Ambil semua data pegawai

        foreach ($pegawaiList as $pegawai) {
            $lokasiPresensi = $pegawai['lokasi_presensi'];
            
            // Ambil jam_masuk berdasarkan lokasi_presensi
            $jamMasukQuery = $lokasiPresensiModel->select('jam_masuk')
                                                ->where('id', $lokasiPresensi)
                                                ->get();
            $jamMasukResult = $jamMasukQuery->getRow();
            
            // Pastikan $jamMasukResult ada dan ambil nilainya
            if ($jamMasukResult) {
                $jamMasuk = $jamMasukResult->jam_masuk;
        
                // Hitung jumlah presensi
                $jumlahAlpha = $presensiModel->where('jam_masuk >', $jamMasuk)->where('DATE_FORMAT(tanggal_masuk, "%Y-%m")', date('Y-m'))->countAllResults();
                
                $data = [
                    'title'             => session()->get('role_id') . ' Dashboard',
                    'total_pegawai'     => $userModel->where('role', 'Pegawai')->where('status', 'Aktif')->countAllResults(),
                    'total_presensi'    => $presensiModel->where('tanggal_masuk', date('Y-m-d'))->countAllResults(),
                    'total_alpha'       => $jumlahAlpha,
                    'ketidakhadiran'    => $ketidakhadiranModel->where('DATE_FORMAT(tanggal_awal, "%Y-%m")', date('Y-m'))->countAllResults()
                ];
            }
        }

        return view('admin/index', $data);
    }
}
