<?php

namespace Modules\Ketidakhadiran\Controllers\Pegawai;

use App\Controllers\BaseController;
use Modules\Ketidakhadiran\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    protected $ketidakhadiranModel;

    public function __construct()
    {
        $this->ketidakhadiranModel = new KetidakhadiranModel();
    }

    public function index()
    {
        $id_pegawai = session()->get('id_pegawai');
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        if (!in_array($bulan, range(1, 12))) { $bulan = date('m'); }
        if (!preg_match('/^\d{4}$/', $tahun)) { $tahun = date('Y'); }

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

        return view('Modules\Ketidakhadiran\Views\pegawai\index', $data);
    }

    public function form($id = null)
    {
        $id_pegawai = session()->get('id_pegawai');
        $ketidakhadiran = $id ? $this->ketidakhadiranModel->where('id_pegawai', $id_pegawai)->where('id', $id)->first() : null;

        $data = [
            'title' => $id ? 'Edit Pengajuan Izin' : 'Pengajuan Izin',
            'ketidakhadiran' => $ketidakhadiran
        ];
        return view('Modules\Ketidakhadiran\Views\pegawai\form', $data);
    }

    public function save($id = null)
    {
        $file = $this->request->getFile('files') ?: $this->request->getFile('file');
        $filePath = $this->request->getPost('existing_file') ?: '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filename = $file->getName();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $filePath = time() . '.' . $extension;
            $folderPath = 'uploads/ketidakhadiran';

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
            }
            $file->move($folderPath, $filePath);
        }

        $id_pegawai = session()->get('id_pegawai');
        $saveData = [
            'id_pegawai'       => $id_pegawai,
            'keterangan'       => $this->request->getPost('keterangan'),
            'tanggal_awal'     => $this->request->getPost('tanggal_awal'),
            'tanggal_akhir'    => $this->request->getPost('tanggal_akhir'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'file'             => $filePath,
            'status_pengajuan' => $this->request->getPost('status_pengajuan') ?: 'menunggu',
        ];

        if ($id) {
            $saveData['id'] = $id;
        }

        $this->ketidakhadiranModel->save($saveData);
        return redirect()->to(base_url('ketidakhadiran'))->with('success', 'Berhasil menyimpan pengajuan.');
    }

    public function delete($id)
    {
        $id_pegawai = session()->get('id_pegawai');
        $ketidakhadiran = $this->ketidakhadiranModel->where('id_pegawai', $id_pegawai)->where('id', $id)->first();
        if ($ketidakhadiran) {
            $filePath = 'uploads/ketidakhadiran/' . $ketidakhadiran['file'];
            if (!empty($ketidakhadiran['file']) && file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }
            $this->ketidakhadiranModel->delete($id);
            session()->setFlashData('success', 'Berhasil membatalkan pengajuan izin');
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
        return view('Modules\Ketidakhadiran\Views\pegawai\detail', $data);
    }
}
