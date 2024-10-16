<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use App\Models\PegawaiModel;

class Ketidakhadiran extends BaseController
{
    protected $ketidakhadiranModel;
    protected $pegawaiModel;
    protected $db;

    public function __construct()
    {
        $this->ketidakhadiranModel = new KetidakhadiranModel();
        $this->pegawaiModel = new \App\Models\PegawaiModel();
        $this->db = \Config\Database::connect(); // Mendapatkan instance database
    }

    public function index()
    {
        $tanggal_aw = $this->request->getGet('tanggal_awal') ?: date('Y-m-d'); // Ambil tanggal dari parameter GET atau gunakan tanggal hari ini
        $tanggal_ak = $this->request->getGet('tanggal_akhir') ?: $tanggal_aw;

        // Ambil nilai bulan dan tahun dari parameter GET atau gunakan nilai default saat ini
        $bulan = $this->request->getGet('bulan') ?: date('m');
        $tahun = $this->request->getGet('tahun') ?: date('Y');

        // Model untuk menghubungkan tabel ketidakhadiran dan pegawai
        $model = new KetidakhadiranModel();

        // Query untuk mendapatkan data ketidakhadiran dan nama pegawai berdasarkan bulan dan tahun
        $ketidakhadiran = $model
            ->select('ketidakhadiran.*, pegawai.nama as nama_pegawai') // Mengambil data ketidakhadiran dengan nama pegawai
            ->join('pegawai', 'pegawai.id = ketidakhadiran.id_pegawai') // Gabungkan tabel ketidakhadiran dengan tabel pegawai
            ->where('MONTH(tanggal_awal)', $bulan)
            ->where('YEAR(tanggal_awal)', $tahun)
            ->findAll();

        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran, // Kirimkan data ketidakhadiran ke view
            'tanggal_awal' => $tanggal_aw, // Kirimkan tanggal ke view
            'tanggal_akhir' => $tanggal_ak,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('admin/ketidakhadiran/ketidakhadiran', $data);
    }


    public function create()
    {
        $pegawaiList = $this->pegawaiModel->findAll(); // Ambil data pegawai dari database

        $data = [
            'title' => 'Tambah Data Ketidakhadiran',
            'pegawaiList' => $pegawaiList, // Kirim data pegawai ke view
        ];
        return view('admin/ketidakhadiran/create', $data);
    }

    public function detail($id)
    {
        // Query dengan join untuk mengambil data ketidakhadiran sekaligus nama pegawai
        $ketidakhadiran = $this->ketidakhadiranModel
            ->select('ketidakhadiran.*, pegawai.nama as nama_pegawai') // Pilih data dari ketidakhadiran dan nama pegawai
            ->join('pegawai', 'pegawai.id = ketidakhadiran.id_pegawai') // Lakukan join tabel pegawai
            ->where('ketidakhadiran.id', $id) // Cari data berdasarkan ID ketidakhadiran
            ->first(); // Ambil satu record

        // Tambahkan pengecekan apakah data ditemukan
        if (!$ketidakhadiran) {
            return redirect()->to('/admin/ketidakhadiran')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran
        ];

        return view('admin/ketidakhadiran/detail', $data);
    }


    public function store()
    {
        // Mengambil ID Pegawai dari form
        $id_pegawai = $this->request->getPost('id_pegawai');

        // Cek apakah ID Pegawai ada di tabel pegawai
        $pegawai = $this->db->table('pegawai')->getWhere(['id' => $id_pegawai])->getFirstRow();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'ID Pegawai tidak ditemukan.');
        }

        // Mengambil file yang diupload
        $file = $this->request->getFile('file');

        // Inisialisasi nama file
        $fileName = '';

        // Cek jika file ada dan valid
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/ketidakhadiran', $fileName);
        }

        // Menyimpan data ke database
        $this->ketidakhadiranModel->save([
            'id_pegawai' => $id_pegawai,
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_awal' => $this->request->getPost('tanggal_awal'),
            'tanggal_akhir' => $this->request->getPost('tanggal_akhir'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName,
            'status_pengajuan' => $this->request->getPost('status_pengajuan'),
        ]);

        return redirect()->to('/admin/ketidakhadiran')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $ketidakhadiran = $this->ketidakhadiranModel->find($id);

        // Tambahkan pengecekan apakah data ditemukan
        if (!$ketidakhadiran) {
            return redirect()->to('/admin/ketidakhadiran')->with('error', 'Data tidak ditemukan.');
        }

        // Ambil data pegawai
        $pegawaiModel = new \App\Models\PegawaiModel();
        $pegawai = $pegawaiModel->find($ketidakhadiran['id_pegawai']);

        $data = [
            'title' => 'Edit Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran,
            'pegawai' => $pegawai
        ];

        return view('admin/ketidakhadiran/edit', $data);
    }


    public function update($id)
    {
        // Mengambil ID Pegawai dari form
        $id_pegawai = $this->request->getPost('id_pegawai');

        // Mengambil file yang diupload
        $file = $this->request->getFile('file');
        $fileName = $this->request->getPost('existing_file');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/ketidakhadiran', $fileName);
        }

        // Update data di database
        $this->ketidakhadiranModel->update($id, [
            'id_pegawai' => $id_pegawai,
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_awal' => $this->request->getPost('tanggal_awal'),
            'tanggal_akhir' => $this->request->getPost('tanggal_akhir'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName,
            'status_pengajuan' => $this->request->getPost('status_pengajuan'),
        ]);

        return redirect()->to('/admin/ketidakhadiran')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $ketidakhadiran = $this->ketidakhadiranModel->find($id);

        if ($ketidakhadiran) {
            // Tentukan path file
            $uploadDir = ROOTPATH . 'public/uploads/ketidakhadiran/';
            $file = basename($ketidakhadiran['file']);
            $filePath = $uploadDir . $file;

            // Hapus file jika ada
            if (file_exists($filePath) && !is_dir($filePath)) {
                unlink($filePath);
            }

            // Hapus data dari database
            $this->ketidakhadiranModel->delete($id);
            session()->setFlashData('success', 'Data ketidakhadiran dan file terkait berhasil dihapus');
        } else {
            session()->setFlashData('error', 'Data tidak ditemukan atau sudah dihapus');
        }

        return redirect()->to('/admin/ketidakhadiran');
    }

    public function show($id)
    {
        $data['ketidakhadiran'] = $this->ketidakhadiranModel->find($id);
        return view('admin/ketidakhadiran/show', $data);
    }

    public function statuses($id, $status)
    {
        $ketidakhadiran = $this->ketidakhadiranModel->find($id);

        if ($ketidakhadiran) {
            // Update data di database
            $this->ketidakhadiranModel->update($id, [
                'status_pengajuan' => ($status == 'disetujui') ? "disetujui" : "ditolak"
            ]);

            return redirect()->to('/admin/ketidakhadiran')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->to('/admin/ketidakhadiran')->with('error', 'Data tidak ditemukan.');
        }

        return redirect()->to('/admin/ketidakhadiran');
    }
}
