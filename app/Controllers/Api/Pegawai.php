<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;
use App\Models\JabatanModel;

class Pegawai extends ResourceController
{
    protected $pegawaiModel;
    protected $userModel;
    protected $lokasiPresensiModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->userModel = new UserModel();
        $this->lokasiPresensiModel = new LokasiPresensiModel();
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        // Get all Pegawai with their associated username from the UserModel
        $pegawai = $this->pegawaiModel
            ->select('pegawai.*, users.username, users.role')
            ->join('users', 'users.id_pegawai = pegawai.id', 'left')
            ->findAll();

        return $this->respond($pegawai, 200);
    }

    /**
     * @param {id} Untuk menampilkan data secara spesifik dengan id
     */
    public function show($id = null)
    {
        // Get the specific Pegawai by ID with the associated username
        $pegawai = $this->pegawaiModel
            ->select('pegawai.*, users.username, users.role, users.password')
            ->join('users', 'users.id_pegawai = pegawai.id', 'left')
            ->where('pegawai.id', $id)
            ->first();

        if (!$pegawai) {
            return $this->failNotFound('Pegawai tidak ditemukan');
        }

        // Optionally, fetch lokasi_presensi details as well
        $lokasiPresensi = $this->lokasiPresensiModel->where('id', $pegawai['lokasi_presensi'])->first();
        $pegawai['lokasi_presensi'] = $lokasiPresensi;

        return $this->respond($pegawai, 200);
    }

    /**
     * Contoh dengan Format JSON untuk data pegawai
     * {
     *   "nama": "User Testing",         // Nama lengkap pegawai
     *   "username": "user",             // Username untuk login
     *   "password": "password123",      // Password untuk login
     *   "jenis_kelamin": "Laki-Laki",   // Jenis kelamin pegawai
     *   "alamat": "Indonesia",          // Alamat domisili pegawai
     *   "no_handphone": "08123456789",  // Nomor handphone pegawai
     *   "jabatan": "IT Support",        // Jabatan atau posisi pegawai
     *   "role": "Pegawai",              // Peran pegawai dalam sistem (misal: Pegawai, Admin)
     *   "lokasi_presensi": 1,           // ID lokasi presensi pegawai (misal: cabang atau kantor)
     *   "foto": "test.jpg"              // Nama file foto profil pegawai
     * }
    */
    public function create()
    {
        // Get data from POST request
        $data = $this->request->getPost();  // Use getPost() to retrieve form data from request

        $rules = [
            'username' => 'required|alpha_numeric|is_unique[users.username]',
            'password' => 'required',
            'jabatan' => 'required',
            'lokasi_presensi' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $nipBaru = $this->generateNIP();

        // Handle file upload
        $foto = $this->request->getFile('foto');
        $nama_foto = $foto && !$foto->getError() ? $foto->getRandomName() : '';
        if ($nama_foto) {
            $foto->move('profile', $nama_foto);
        }

        // Insert Pegawai
        $this->pegawaiModel->insert([
            'nip' => $nipBaru,
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
            'no_handphone' => $data['no_handphone'],
            'jabatan' => $data['jabatan'],
            'lokasi_presensi' => $data['lokasi_presensi'],
            'foto' => $nama_foto,
        ]);

        $idPegawai = $this->pegawaiModel->insertID();

        // Insert User
        $this->userModel->insert([
            'id_pegawai' => $idPegawai,
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'status' => 'Aktif',
            'role' => $data['role'],
        ]);

        return $this->respondCreated(['message' => 'Pegawai berhasil ditambahkan.']);
    }

    public function update($id = null)
    {
        // Get data from POST or PUT request
        $data = $this->request->getRawInput();  // Use getRawInput() to capture PUT data or getPost() for form data

        $rules = [
            'username' => 'alpha_numeric',
            'jabatan' => 'required',
            'lokasi_presensi' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Handle file upload
        $foto = $this->request->getFile('foto');
        $nama_foto = $foto && !$foto->getError() ? $foto->getRandomName() : '';
        if ($nama_foto && $foto && !$foto->getError()) {
            $foto->move('profile', $nama_foto);
        }

        // Update Pegawai
        $this->pegawaiModel->update($id, [
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
            'no_handphone' => $data['no_handphone'],
            'jabatan' => $data['jabatan'],
            'lokasi_presensi' => $data['lokasi_presensi'],
            'foto' => $nama_foto,
        ]);

        // Update User
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userModel->where('id_pegawai', $id)->set([
            'username' => $data['username'],
            'password' => $password,
            'status' => 'Aktif',
            'role' => $data['role'],
        ])->update();

        return $this->respond(['message' => 'Pegawai berhasil diperbarui.']);
    }

    public function delete($id = null)
    {
        $pegawai = $this->pegawaiModel->find($id);
        if (!$pegawai) {
            return $this->failNotFound('Pegawai tidak ditemukan');
        }

        $this->userModel->where('id_pegawai', $id)->delete();
        $this->pegawaiModel->delete($id);

        return $this->respondDeleted(['message' => 'Pegawai berhasil dihapus.']);
    }

    private function generateNIP()
    {
        $pegawaiTerakhir = $this->pegawaiModel->select('nip')->orderBy('id', 'DESC')->first();
        $nipTerakhir = $pegawaiTerakhir ? $pegawaiTerakhir['nip'] : 'PEG-0000';
        $angkaNIP = (int) substr($nipTerakhir, 4);
        $angkaNIP++;
        return 'PEG-' . str_pad($angkaNIP, 4, '0', STR_PAD_LEFT);
    }
}
