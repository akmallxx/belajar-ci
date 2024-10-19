<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends BaseController
{
    public function rekap_presensi()
    {
        $data = [
            'title' => 'Rekap Presensi API Docs'
        ];
        return view('admin/api/rekap_presensi', $data);
    }

    public function jabatan()
    {
        $data = [
            'title' => 'Jabatan API Docs'
        ];
        return view('admin/api/jabatan', $data);
    }

    public function pegawai()
    {
        $data = [
            'title' => 'Pegawai API Docs'
        ];
        return view('admin/api/pegawai', $data);
    }

    public function ketidakhadiran()
    {
        $data = [
            'title' => 'Ketidakhadiran API Docs'
        ];
        return view('admin/api/ketidakhadiran', $data);
    }

    public function lokasi_presensi()
    {
        $data = [
            'title' => 'Lokasi Presensi API Docs'
        ];
        return view('admin/api/lokasi_presensi', $data);
    }
}
