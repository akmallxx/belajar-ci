<?php

namespace Modules\Ketidakhadiran\Controllers\Admin;

use App\Controllers\BaseController;
use Modules\Ketidakhadiran\Models\KetidakhadiranModel;
use Modules\Pegawai\Models\PegawaiModel;

class Ketidakhadiran extends BaseController
{
    protected $ketidakhadiranModel;
    protected $pegawaiModel;
    protected $db;

    public function __construct()
    {
        $this->ketidakhadiranModel = new KetidakhadiranModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tanggal_aw = $this->request->getGet('tanggal_awal') ?: date('Y-m-d');
        $tanggal_ak = $this->request->getGet('tanggal_akhir') ?: $tanggal_aw;

        $bulan = $this->request->getGet('bulan') ?: date('m');
        $tahun = $this->request->getGet('tahun') ?: date('Y');

        $ketidakhadiran = $this->ketidakhadiranModel
            ->select('dat_ketidakhadiran.*, mst_pegawai.nama as nama_pegawai')
            ->join('mst_pegawai', 'mst_pegawai.id = dat_ketidakhadiran.id_pegawai')
            ->where('MONTH(tanggal_awal)', $bulan)
            ->where('YEAR(tanggal_awal)', $tahun)
            ->findAll();

        $data = [
            'title'          => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran,
            'tanggal_awal'   => $tanggal_aw,
            'tanggal_akhir'  => $tanggal_ak,
            'bulan'          => $bulan,
            'tahun'          => $tahun
        ];

        return view('Modules\Ketidakhadiran\Views\admin\ketidakhadiran', $data);
    }

    public function form($id = null)
    {
        $ketidakhadiran = $id ? $this->ketidakhadiranModel->find($id) : null;
        $data = [
            'title'          => $id ? 'Edit Data Ketidakhadiran' : 'Tambah Data Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran,
            'pegawaiList'    => $this->pegawaiModel->findAll()
        ];
        return view('Modules\Ketidakhadiran\Views\admin\form', $data);
    }

    public function save($id = null)
    {
        $id_pegawai = $this->request->getPost('id_pegawai');
        $pegawai = $this->db->table('mst_pegawai')->getWhere(['id' => $id_pegawai])->getFirstRow();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'ID Pegawai tidak ditemukan.');
        }

        $file = $this->request->getFile('file');
        $fileName = $this->request->getPost('existing_file') ?: '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/ketidakhadiran', $fileName);
        }

        $saveData = [
            'id_pegawai'       => $id_pegawai,
            'keterangan'       => $this->request->getPost('keterangan'),
            'tanggal_awal'     => $this->request->getPost('tanggal_awal'),
            'tanggal_akhir'    => $this->request->getPost('tanggal_akhir'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'file'             => $fileName,
            'status_pengajuan' => $this->request->getPost('status_pengajuan') ?: 'menunggu',
        ];

        if ($id) {
            $saveData['id'] = $id;
        }

        $this->ketidakhadiranModel->save($saveData);
        return redirect()->to('/admin/ketidakhadiran')->with('success', 'Data berhasil disimpan.');
    }

    public function detail($id)
    {
        $ketidakhadiran = $this->ketidakhadiranModel
            ->select('dat_ketidakhadiran.*, mst_pegawai.nama as nama_pegawai')
            ->join('mst_pegawai', 'mst_pegawai.id = dat_ketidakhadiran.id_pegawai')
            ->where('dat_ketidakhadiran.id', $id)
            ->first();

        if (!$ketidakhadiran) {
            return redirect()->to('/admin/ketidakhadiran')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title'          => 'Detail Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran
        ];

        return view('Modules\Ketidakhadiran\Views\admin\detail', $data);
    }

    public function delete($id)
    {
        $ketidakhadiran = $this->ketidakhadiranModel->find($id);
        if ($ketidakhadiran) {
            $uploadDir = ROOTPATH . 'public/uploads/ketidakhadiran/';
            $file = basename($ketidakhadiran['file']);
            $filePath = $uploadDir . $file;

            if (file_exists($filePath) && !is_dir($filePath)) {
                unlink($filePath);
            }

            $this->ketidakhadiranModel->delete($id);
            session()->setFlashData('success', 'Data ketidakhadiran berhasil dihapus');
        }

        return redirect()->to('/admin/ketidakhadiran');
    }

    public function statuses($id, $status)
    {
        $ketidakhadiran = $this->ketidakhadiranModel->find($id);
        if ($ketidakhadiran) {
            $this->ketidakhadiranModel->update($id, [
                'status_pengajuan' => ($status == 'disetujui') ? "disetujui" : "ditolak"
            ]);
            return redirect()->to('/admin/ketidakhadiran')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->to('/admin/ketidakhadiran')->with('error', 'Data tidak ditemukan.');
    }
}
