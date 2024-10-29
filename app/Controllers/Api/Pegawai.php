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

    // API key Validation
    private function validateApiKey()
    {
        $authorizationHeader = $this->request->getHeaderLine('Authorization');
        
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            $apiKey = substr($authorizationHeader, 7);
        } else {
            $apiKey = $this->request->getVar('api_key');
        }
    
        $validApiKey = env('app.API_KEY');
    
        if ($apiKey !== $validApiKey) {
            return false;
        }
    
        return true;
    }

    public function index()
    {
        // Validasi API key
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('Invalid API Key'); // Jika tidak valid, kembalikan error
        }

        $pegawai = $this->pegawaiModel
            ->select('pegawai.*, users.username, users.password, users.role')
            ->join('users', 'users.id_pegawai = pegawai.id', 'left')
            ->findAll();

        return $this->respond($pegawai, 200);
    }

    public function show($id = null)
    {
        // Validasi API key
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('Invalid API Key'); // Jika tidak valid, kembalikan error
        }

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

    public function create()
    {
        // Validasi API key
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('Invalid API Key'); // Jika tidak valid, kembalikan error
        }

        // Get data from POST request
        $data = $this->request->getPost();

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
        // Validasi API key
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('Invalid API Key'); // Jika tidak valid, kembalikan error
        }

        // Ambil data dari request
        // Menggunakan getVar() yang bisa menangkap data dari URL query, POST, atau PUT
        $data = $this->request->getVar();

        // Ambil data pegawai dari database
        $pegawai = $this->pegawaiModel->find($id);
        if (!$pegawai) {
            return $this->failNotFound('Pegawai tidak ditemukan.');
        }

        // Validasi input, hanya memvalidasi field yang ada di input
        $rules = [
            'username' => 'permit_empty|alpha_numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors(),
                'data' => $data // Sekarang $data akan berisi data yang diambil dari request
            ]);
        }

        // Cek parameter kosong, gunakan data dari database jika kosong
        $nama = !empty($data['nama']) ? $data['nama'] : $pegawai['nama'];
        $jenis_kelamin = !empty($data['jenis_kelamin']) ? $data['jenis_kelamin'] : $pegawai['jenis_kelamin'];
        $alamat = !empty($data['alamat']) ? $data['alamat'] : $pegawai['alamat'];
        $no_handphone = !empty($data['no_handphone']) ? $data['no_handphone'] : $pegawai['no_handphone'];
        $jabatan = !empty($data['jabatan']) ? $data['jabatan'] : $pegawai['jabatan'];
        $lokasi_presensi = !empty($data['lokasi_presensi']) ? $data['lokasi_presensi'] : $pegawai['lokasi_presensi'];

        // Handle file upload
        $foto = $this->request->getFile('foto');
        $nama_foto = $foto && !$foto->getError() ? $foto->getRandomName() : $pegawai['foto'];
        if ($nama_foto && $foto && !$foto->getError()) {
            $foto->move('profile', $nama_foto);
        }

        // Update Pegawai
        $this->pegawaiModel->update($id, [
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
            'no_handphone' => $no_handphone,
            'jabatan' => $jabatan,
            'lokasi_presensi' => $lokasi_presensi,
            'foto' => $nama_foto,
        ]);

        // Ambil data user dari database
        $user = $this->userModel->where('id_pegawai', $id)->first();
        if (!$user) {
            return $this->failNotFound('User tidak ditemukan.');
        }

        // Update User
        $username = !empty($data['username']) ? $data['username'] : $user['username'];
        $password = !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : $user['password'];
        $role = !empty($data['role']) ? $data['role'] : $user['role'];

        $this->userModel->where('id_pegawai', $id)->set([
            'username' => $username,
            'password' => $password,
            'status' => 'Aktif',
            'role' => $role,
        ])->update();

        return $this->respond(['message' => 'Pegawai berhasil diperbarui.']);
    }

    public function delete($id = null)
    {
        // Validasi API key
        if (!$this->validateApiKey()) {
            return $this->failUnauthorized('Invalid API Key'); // Jika tidak valid, kembalikan error
        }

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
