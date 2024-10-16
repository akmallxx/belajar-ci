<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    protected $ketidakhadiranModel;

    public function __construct()
    {
        $this->ketidakhadiranModel = new KetidakhadiranModel();
    }

    public function index()
    {
        // Ambil ID pegawai dari session
        $id_pegawai = session()->get('id_pegawai');

        // Ambil bulan dan tahun dari query string
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        // Validasi input bulan dan tahun
        if (!in_array($bulan, range(1, 12))) {
            $bulan = date('m');
        }
        if (!preg_match('/^\d{4}$/', $tahun)) {
            $tahun = date('Y');
        }

        // Buat query untuk mengambil data ketidakhadiran
        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $this->ketidakhadiranModel
                ->where('id_pegawai', $id_pegawai)
                ->where("MONTH(tanggal_awal)", $bulan)
                ->where("YEAR(tanggal_awal)", $tahun)
                ->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('pegawai/ketidakhadiran/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Pengajuan Izin',
        ];
        return view('pegawai/ketidakhadiran/create', $data);
    }



    public function store()
    {
        $file = $this->request->getFile('files');

        // Cek jika file ada
        if (!$file || $file->getError() == 4) {
            $filePath = '';
        } else {
            $filename = $file->getName();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $filePath = time() . '.' . $extension;

            // Pastikan folder 'uploads/ketidakhadiran' ada
            $folderPath = 'uploads/ketidakhadiran';
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $file->move($folderPath, $filePath);
        }

        $id_pegawai = session()->get('id_pegawai'); // Ambil ID pegawai dari session
        $data = [
            'id_pegawai' => $id_pegawai,
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_awal' => $this->request->getPost('tanggal_awal'),
            'tanggal_akhir' => $this->request->getPost('tanggal_akhir'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $filePath,
            'status_pengajuan' => $this->request->getPost('status_pengajuan'),
        ];
        $this->ketidakhadiranModel->insert($data);

        // Setelah pengajuan berhasil, kirim notifikasi ke Discord
        // $this->sendDiscordWebhook("**: $id_pegawai telah mengajukan izin ketidakhadiran dari tanggal " . $data['tanggal_awal'] . " sampai tanggal " . $data['tanggal_akhir']);

        $message = ":orange_circle: | **" . session()->get('nama') . "** telah mengajukan izin ketidakhadiran dari tanggal ** $data[tanggal_awal] ** sampai tanggal **$data[tanggal_akhir]**.";
        $this->sendDiscordWebhook($message);

        return redirect()->to(base_url('ketidakhadiran'))->with('success', 'Berhasil mengajukan izin.');
    }
    // :orange_circle: | 



    public function update($id)
    {
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $filename = $file->getRandomName();
            $folderPath = 'uploads/ketidakhadiran';

            // Pastikan folder 'uploads/ketidakhadiran' ada
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $file->move($folderPath, $filename);
            $filePath = $filename;
        } else {
            $filePath = $this->request->getPost('existing_file'); // Gunakan file yang ada jika tidak ada file baru
        }

        $data = [
            'deskripsi' => $this->request->getPost('deskripsi'),
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_awal' => $this->request->getPost('tanggal_awal'), // Perbaiki kesalahan tanggal
            'tanggal_akhir' => $this->request->getPost('tanggal_akhir'), // Perbaiki kesalahan tanggal
            'file' => $filePath
        ];

        $this->ketidakhadiranModel->update($id, $data);
        return redirect()->to('pegawai/ketidakhadiran');
    }

    public function delete($id)
    {
        $id_pegawai = session()->get('id_pegawai');
        $ketidakhadiran = $this->ketidakhadiranModel->where('id_pegawai', $id_pegawai)->where('id', $id)->first();
        if ($ketidakhadiran) {
            $filePath = 'uploads/ketidakhadiran/' . $ketidakhadiran['file'];

            // Pastikan $ketidakhadiran['file'] bukan kosong dan benar-benar file
            if (!empty($ketidakhadiran['file']) && file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }

            $this->ketidakhadiranModel->delete($id);
            session()->setFlashData('success', 'Berhasil membatalkan pengajuan izin');
        } else {
            session()->setFlashData('error', 'Data tidak ditemukan.');
        }

        return redirect()->to(base_url('ketidakhadiran'));
    }

    public function detail($id)
    {
        $id_pegawai = session()->get('id_pegawai');
        $ketidakhadiran = $this->ketidakhadiranModel->where('id_pegawai', $id_pegawai)->where('id', $id)->first();
        $data = [
            'title' => 'Detail',
            'pegawai' => session()->get('pegawai'),
            'ketidakhadiran' => $ketidakhadiran
        ];
        return view('pegawai/ketidakhadiran/detail', $data);
    }

    private function sendDiscordWebhook($message)
    {
        $url = env('app.webhook_url');
        $ch = curl_init($url);

        $jsonData = json_encode([
            "content" => $message,
        ]);

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        curl_close($ch);
    }
}
