<?php

namespace Modules\Pegawai\Controllers\Admin;

use App\Controllers\BaseController;
use Modules\Pegawai\Models\PegawaiModel;
use Modules\Auth\Models\UserModel;
use Modules\LokasiPresensi\Models\LokasiPresensiModel;
use Modules\Jabatan\Models\JabatanModel;

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
        return view('Modules\Pegawai\Views\admin\data_pegawai', $data);
    }

    public function detail($id)
    {
        $pegawaiModel = new PegawaiModel();
        $lokasi_presensi = new LokasiPresensiModel();
        $pegawai = $pegawaiModel->detailPegawai($id);

        $data = [
            'title' => 'Detail Data Pegawai',
            'lokasi_presensi' => $lokasi_presensi->where('id', $pegawai['lokasi_presensi'])->first(),
            'pegawai' => $pegawai
        ];

        return view('Modules\Pegawai\Views\admin\detail', $data);
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

    public function form($id = null)
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan = new JabatanModel();
        $pegawaiModel = new PegawaiModel();

        $data = [
            'title' => $id ? 'Edit Data Pegawai' : 'Tambah Data Pegawai',
            'pegawai' => $id ? $pegawaiModel->editPegawai($id) : null,
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('Modules\Pegawai\Views\admin\form', $data);
    }

    public function save($id = null)
    {
        $isUniqueUser = $id ? '' : '|is_unique[mst_users.username]';
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
            'username' => [
                'rules' => 'alpha_numeric' . $isUniqueUser,
                'errors' => [
                    'alpha_numeric' => 'Username hanya boleh mengandung huruf dan angka, tanpa spasi.',
                    'is_unique' => 'Username sudah digunakan.'
                ],
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->form($id);
        }

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $nama_foto = $foto->getRandomName();
            $foto->move('profile', $nama_foto);
        } else {
            $nama_foto = $this->request->getPost('foto_digunakan') ?: '';
        }

        $pegawaiModel = new PegawaiModel();
        $pegawaiData = [
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'no_handphone' => $this->request->getPost('no_handphone'),
            'jabatan' => $this->request->getPost('jabatan'),
            'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
            'foto' => $nama_foto
        ];

        if ($id) {
            $pegawaiData['id'] = $id;
            $pegawaiModel->save($pegawaiData);
            $id_pegawai = $id;
        } else {
            $pegawaiData['nip'] = $this->generateNIP();
            $pegawaiModel->insert($pegawaiData);
            $id_pegawai = $pegawaiModel->insertID();
        }

        $userModel = new UserModel();
        $userPass = $this->request->getPost('password');
        if (empty($userPass)) {
            $password = $this->request->getPost('password_digunakan');
        } else {
            $password = password_hash($userPass, PASSWORD_DEFAULT);
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'status'   => 'Aktif',
            'role'     => $this->request->getPost('role'),
        ];

        $user = $userModel->where('id_pegawai', $id_pegawai)->first();
        if ($user) {
            $userModel->update($user['id'], $userData);
        } else {
            $userData['id_pegawai'] = $id_pegawai;
            $userModel->insert($userData);
        }

        session()->setFlashData('success', 'Data Pegawai berhasil disimpan');
        return redirect()->to(base_url('admin/data_pegawai'));
    }

    public function delete($id)
    {
        $pegawaiModel = new PegawaiModel();
        $userModel = new UserModel();
        $pegawai = $pegawaiModel->find($id);
        if ($pegawai) {
            $userModel->where('id_pegawai', $id)->delete();
            $pegawaiModel->delete($id);
            session()->setFlashData('success', 'Data Pegawai berhasil dihapus');
        }
        return redirect()->to(base_url('admin/data_pegawai'));
    }
}
