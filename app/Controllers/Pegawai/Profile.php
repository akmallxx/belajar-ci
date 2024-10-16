<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;

class Profile extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Profile',
        ];
        return view('pegawai/profile/index', $data);
    }

    public function edit()
    {
        $session = session();

        $lokasi_presensi = new LokasiPresensiModel();
        $pegawaiModel = new PegawaiModel();
        $userModel = new UserModel();

        $user = $userModel->where('username', $session->get('username'))->first();

        $data = [
            'title' => 'Edit Data Pegawai',
            'pegawai' => $pegawaiModel->editPegawai($user['id']),
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('pegawai/profile/edit', $data);
    }

    public function update()
    {
        $session = session();

        $userModel = new UserModel();
        $user = $userModel->where('username', $session->get('username'))->first();

        $id = $user['id'];

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
            $pegawaiModel = new PegawaiModel();
            $data = [
                'title' => 'Edit Data Pegawai',
                'pegawai' => $pegawaiModel->editPegawai($id),
                'validation' => \Config\Services::validation()
            ];
            return view('pegawai/profile/edit', $data);
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
                ])
                ->update();

            $lokasi_presensi = new LokasiPresensiModel();

            $pegawai = $pegawaiModel->detailPegawai($user['id']);
            $cekPegawai = $pegawaiModel->where('id', $user['id_pegawai'])->first();
            $session_data = [
                'username'  => $this->request->getPost('username'),
                'role_id'   => $session->get('role_id'),
                'logged_in' => true,
                'foto'      => base_url($cekPegawai['foto'] ? 'profile/' . $cekPegawai['foto'] : 'profile/nopp.png'),
                'nama'      => $cekPegawai['nama'],
                'id_pegawai' => $user['id'],
                'lokasi' => $lokasi_presensi->where('id', $pegawai['lokasi_presensi'])->first(),
                'pegawai' => $pegawai
            ];
            // $session->destroy();
            $session->set($session_data);

            session()->setFlashData('success', 'Profile berhasil diubah');

            return redirect()->to(base_url('profile'));
        }
    }
}
