<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;
use App\Models\JabatanModel;

class DataPegawai extends BaseController
{
    
    function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Data Pegawai',
            'pegawai' => $pegawaiModel->findAll()
        ];
        return view('admin/data_pegawai/data_pegawai', $data);
    }

    public function detail($id)
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Detail Data Pegawai',
            'pegawai' => $pegawaiModel->detailPegawai($id)
        ];

        return view('admin/data_pegawai/detail', $data);
    }


    public function create()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan = new JabatanModel();
        $data = [
            'title' => 'Tambah Data Pegawai',
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/create', $data);
    }

    public function generateNIP()
    {
        $pegawaiModel = new PegawaiModel();
        $pegawaiTerakhir = $pegawaiModel->select('nip')->orderBy('id', 'DESC')->first();
        $nipTerakhir = $pegawaiTerakhir ? $pegawaiTerakhir['nip'] : 'PEG-0000';
        $angkaNIP = (int) substr($nipTerakhir, 4);
        $angkaNIP++;
        return 'PEG-' . str_pad($angkaNIP, 4, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        $rules = [
            'foto' => [
                'rules' => 'max_size[foto,20480]|mime_in[foto,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran foto melebihi 20MB',
                    'mime_in' => 'Jenis file yang diizinkan hanya png dan jpeg'
                ],
            ],
            'konfirmasi_password' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok!'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $lokasi_presensi = new LokasiPresensiModel();
            $jabatan = new JabatanModel();
            $data = [
                'title' => 'Tambah Pegawai',
                'lokasi_presensi' =>$lokasi_presensi->findAll(),
                'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/data_pegawai/create', $data);
        } else {
            $nipBaru = $this->generateNIP();

            $foto = $this->request->getFile('foto');

            if ($foto->getError() == 4) {
                $nama_foto = '';
            } else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile', $nama_foto);
            }


            $pegawaiModel = new PegawaiModel();
            $pegawaiModel->insert([
                'nip' => $nipBaru,
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'jabatan' => $this->request->getPost('jabatan'),
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
                'foto' => $nama_foto,
            ]);

            $id_pegawai = $pegawaiModel->insertID();
            $userModel = new UserModel();
            $userModel->insert([
                'id_pegawai' => $id_pegawai,
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'status' => 'Aktif',
                'role' => $this->request->getPost('role'),
            ]);

            session()->setFlashData('success', 'Data Pegawai berhasil disimpan');
    
            return redirect()->to(base_url('admin/data_pegawai'));
        }
    }

    public function edit($id)
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan = new JabatanModel();
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Edit Data Pegawai',
            'pegawai' => $pegawaiModel->editPegawai($id),
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'foto' => [
                'rules' => 'max_size[foto,20480]|mime_in[foto,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran foto melebihi 20MB',
                    'mime_in' => 'Jenis file yang diizinkan hanya png dan jpeg'
                ],
            ],
            'konfirmasi_password' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok!'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $lokasi_presensi = new LokasiPresensiModel();
            $jabatan = new JabatanModel();
            $pegawaiModel = new PegawaiModel();
            $data = [
                'title' => 'Edit Data Pegawai',
                'pegawai' => $pegawaiModel->editPegawai($id),
                'lokasi_presensi' => $lokasi_presensi->findAll(),
                'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
                'validation' => \Config\Services::validation()
            ];
            return view('admin/data_pegawai/edit', $data);
        } else {

            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4) {
                $nama_foto = $this->request->getPost('foto_digunakan');
            } else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile', $nama_foto);
            }
    
            $pegawaiModel = new PegawaiModel();
            $pegawaiModel->update($id, [
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'jabatan' => $this->request->getPost('jabatan'),
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
                'foto' => $nama_foto
            ]);
    
            if ($this->request->getPost('password') == '') {
                $password = $this->request->getPost('password_digunakan');
            } else {
                $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }
            // dd($password);
            $userModel = new UserModel();
            $userModel
                ->where('id_pegawai', $id)
                ->set([
                    'username' => $this->request->getPost('username'),
                    'password' => $password,
                    'status' => 'Aktif',
                    'role' => $this->request->getPost('role'),
                    ])
                ->update();
    
            session()->setFlashData('success', 'Data Pegawai berhasil diubah');

            return redirect()->to(base_url('admin/data_pegawai'));
        }

    }

    public function delete($id) {
        $pegawaiModel = new PegawaiModel();
        $userModel = new UserModel();
        $pegawai = $pegawaiModel->find($id);
        if ($pegawai) {
            $userModel->where('id_pegawai', $id)->delete();
            $pegawaiModel->delete($id);
            session()->setFlashData('success', 'Data Pegawai berhasil dihapus');

            return redirect()->to(base_url('admin/data_pegawai'));
        }
    }
}
