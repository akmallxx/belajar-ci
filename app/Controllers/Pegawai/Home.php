<?php

namespace App\Controllers\Pegawai;

use App\Controllers\Admin\LokasiPresensi;
use App\Controllers\BaseController;
use App\Database\Migrations\Pegawai;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;

class Home extends BaseController
{
    public function index()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $pegawaiModel = new PegawaiModel();
        $id_pegawai = session()->get('id_pegawai');
        $presensi_model = new PresensiModel();
        $pegawai = $pegawaiModel->where('id', $id_pegawai)->first();

        $data = [
            'title' => session()->get('role_id') . ' Dashboard',
            'lokasi_presensi' => $lokasi_presensi->where('id', $pegawai['lokasi_presensi'])->first(),
            'cek_presensi' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->countAllResults(),
            'get_presensi' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->first() ?? 0
        ];
        // dd($data);

        return view('pegawai/index', $data);
    }

    public function presensi_masuk()
    {
        $latitude_pegawai = (float) $this->request->getPost('latitude_pegawai');
        $longitude_pegawai = (float) $this->request->getPost('longitude_pegawai');
        $latitude_kantor = (float) $this->request->getPost('latitude_kantor');
        $longitude_kantor = (float) $this->request->getPost('longitude_kantor');
        $radius = (float) $this->request->getPost('radius');

        // Menghitung jarak
        $theta = $longitude_pegawai - $longitude_kantor;
        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($theta));
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $jarakPegawai = floor($mil * 1.609344 * 1000); // menggunakan satuan meter
        
        // dd($jarakPegawai, $radius);

        if ($jarakPegawai <= $radius) {
            $data = [
                'title' => 'Ambil Foto Selfie',
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
            ];

            return view('pegawai/ambil_foto', $data);

            return redirect()->to(base_url('pegawai/home'));
        } else {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi masuk!");
            session()->setFlashdata('saText', "Anda berada " . number_format($jarakPegawai - $radius) . " meter diluar radius presensi.");

            return redirect()->to(base_url('pegawai/home'));
        }
    }

    public function presensi_masuk_aksi()
    {
        $request = \Config\Services::request();
        $id_pegawai = $request->getPost('id_pegawai');
        $tanggal_masuk = $request->getPost('tanggal_masuk');
        $jam_masuk = $request->getPost('jam_masuk');

        $foto_masuk = $request->getPost('foto_masuk');
        $foto_masuk = str_replace('data:image/jpeg;base64,','', $foto_masuk);
        $foto_masuk = base64_decode($foto_masuk);

        $foto_dir = 'uploads/' . $id_pegawai . '_' . time() . '.jpg';
        $nama_foto = $id_pegawai . '_' . time() . '.jpg';
        file_put_contents($foto_dir, $foto_masuk);

        $presensi_model = new PresensiModel();
        $presensi_model->insert([
            'id_pegawai' => $id_pegawai,
            'jam_masuk' => $jam_masuk,
            'tanggal_masuk' => $tanggal_masuk,
            'foto_masuk' => $nama_foto
        ]);
        session()->setFlashdata('saIcon', 'success');
        session()->setFlashdata('saTitle', "Berhasil melakukan presensi masuk!");
        session()->setFlashdata('saText', ".");

        return redirect()->to(base_url('pegawai/home'));
    }

    public function presensi_keluar($id)
    {
        $latitude_pegawai = (float) $this->request->getPost('latitude_pegawai');
        $longitude_pegawai = (float) $this->request->getPost('longitude_pegawai');
        $latitude_kantor = (float) $this->request->getPost('latitude_kantor');
        $longitude_kantor = (float) $this->request->getPost('longitude_kantor');
        $radius = $this->request->getPost('radius');

        // Menghitung jarak
        $theta = $longitude_pegawai - $longitude_kantor;
        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($theta));
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $jarakPegawai = floor($mil * 1.609344 * 1000); // menggunakan satuan meter

        // dd($latitude_kantor, $latitude_pegawai);
        if ($longitude_pegawai == '' && $latitude_pegawai == '') {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi keluar!");
            session()->setFlashdata('saText', "Mohon izinkan akses lokasi anda untuk melakukan presensi.");

            return redirect()->to(base_url('pegawai/home'));
        }

        if ($jarakPegawai <= $radius) {
            $data = [
                'title' => 'Ambil Foto Selfie',
                'id_presensi' => $id,
                'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
                'jam_keluar' => $this->request->getPost('jam_keluar'),
            ];

            return view('pegawai/ambil_foto_keluar', $data);

            return redirect()->to(base_url('pegawai/home'));
        } else {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi keluar!");
            session()->setFlashdata('saText', "Anda berada " . number_format($jarakPegawai - $radius) . " meter diluar radius presensi.");

            return redirect()->to(base_url('pegawai/home'));
        }
    }

    public function presensi_keluar_aksi($id)
    {
        $request = \Config\Services::request();
        $tanggal_keluar = $request->getPost('tanggal_keluar');
        $jam_keluar = $request->getPost('jam_keluar');

        $foto_keluar = $request->getPost('foto_keluar');
        $foto_keluar = str_replace('data:image/jpeg;base64,','', $foto_keluar);
        $foto_keluar = base64_decode($foto_keluar);

        $foto_dir = 'uploads/' . $id . '_' . time() . '.jpg';
        $nama_foto = $id . '_' . time() . '.jpg';
        file_put_contents($foto_dir, $foto_keluar);

        $presensi_model = new PresensiModel();
        $presensi_model->update($id, [
            'id' => $id,
            'jam_keluar' => $jam_keluar,
            'tanggal_keluar' => $tanggal_keluar,
            'foto_keluar' => $nama_foto
        ]);
        session()->setFlashdata('saIcon', 'success');
        session()->setFlashdata('saTitle', "Berhasil melakukan presensi keluar!");
        session()->setFlashdata('saText', ".");

        return redirect()->to(base_url('pegawai/home'));
    }
}
