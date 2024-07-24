<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\PegawaiModel;

class User extends BaseController
{
    public function login()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('login', $data);
    }
    public function register()
    {
        //
    }
    public function login_action()
    {
        $session = session();
        $userModel = new UserModel;
        $pegawaiModel = new PegawaiModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $cekUsername = $userModel->where('username', $username)->first();

        if ($cekUsername) {
            $password_db = $cekUsername['password'];
            $cekPassword = password_verify($password, $password_db);
            $cekPegawai = $pegawaiModel->where('id', $cekUsername['id_pegawai'])->first();
            $cekFoto = base_url($cekPegawai['foto'] ? 'profile/' . $cekPegawai['foto'] : 'profile/nopp.png');
            if ($cekPassword) {
                $session_data = [
                    'username'  => $cekUsername['username'],
                    'role_id'   => $cekUsername['role'],
                    'logged_in' => true,
                    'foto'      => $cekFoto,
                    'nama'      => $cekPegawai['nama'],
                    'id_pegawai' => $cekUsername['id']
                ];
                $session->set($session_data);
                switch ($cekUsername['role']) {
                    case 'Admin':
                        return redirect()->to(base_url('admin/home'));
                        break;
                    case 'Pegawai':
                        
                        return redirect()->to(base_url('pegawai/home'));
                        break;
                    
                    default:
                        $session->setFlashData('pesan', 'Akun anda belum terdaftar!');
                        return redirect()-> to(base_url('login'));
                        break;
                }
            } else {
                $session->setFlashData('pesan', 'Password salah!');
                return redirect()-> to(base_url('login'));
            }
        } else {
            $session->setFlashData('pesan', "Username '$username' tidak terdaftar!");
            return redirect()-> to(base_url('login'));
        }
    }

    public function logout()
    {
            $session = session();
            $session->destroy();
            return redirect()->to(base_url('login'));
    }
}
