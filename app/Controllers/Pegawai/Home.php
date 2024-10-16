<?php

namespace App\Controllers\Pegawai;

use App\Controllers\Admin\LokasiPresensi;
use App\Controllers\BaseController;
use App\Database\Migrations\Pegawai;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $pegawaiModel = new PegawaiModel();
        $id_pegawai = session()->get('id_pegawai');
        $presensi_model = new PresensiModel();
        $pegawai = $pegawaiModel->where('id', $id_pegawai)->first();

        $lokpres =  $this->request->getGet('lokpres');

        if ($lokpres == null) {
            $lokpret = (int) $pegawai['lokasi_presensi'];
        } else {
            $lokpret = (int) $lokpres;
        }

        $pegawaiModel->update($id_pegawai, [
            'lokasi_presensi' => (int) $lokpret
        ]);

        $data = [
            'title' => session()->get('role_id') . ' Dashboard',
            'lokasi_presensi' => $lokasi_presensi->where('id', $lokpret)->first(),
            'lokprez' => $lokasi_presensi->findAll(),
            'cek_presensi' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->countAllResults(),
            'get_presensi' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->first() ?? 0,
            'pegawai' => $pegawai,
            'lokpret' => $lokpret,
        ];

        return view('pegawai/index', $data);
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

    // Fungsi presensi masuk
    public function presensi_masuk()
    {
        $latitude_pegawai = (float) $this->request->getPost('latitude_pegawai');
        $longitude_pegawai = (float) $this->request->getPost('longitude_pegawai');
        $latitude_kantor = (float) $this->request->getPost('latitude_kantor');
        $longitude_kantor = (float) $this->request->getPost('longitude_kantor');
        $radius = (float) $this->request->getPost('radius');

        // Menghitung jarak
        $theta = $longitude_pegawai - $longitude_kantor;
        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($theta));
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $jarakPegawai = floor($mil * 1.609344 * 1000); // menggunakan satuan meter

        if ($longitude_pegawai < 1 && $latitude_pegawai < 1) {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi masuk!");
            session()->setFlashdata('saText', "Mohon izinkan akses lokasi anda untuk melakukan presensi.");

            return redirect()->to(base_url('home'));
        }

        if ($jarakPegawai <= $radius) {
            $data = [
                'title' => 'Ambil Foto Selfie',
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi')
            ];

            return view('pegawai/ambil_foto', $data);
        } else {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi masuk!");
            session()->setFlashdata('saText', "Anda berada " . number_format($jarakPegawai - $radius) . " meter diluar radius presensi.");

            return redirect()->to(base_url('home'));
        }
    }

    // Fungsi aksi presensi masuk
    public function presensi_masuk_aksi()
    {
        $request = \Config\Services::request();
        $id_pegawai = $request->getPost('id_pegawai');
        $tanggal_masuk = $request->getPost('tanggal_masuk');
        $jam_masuk = $request->getPost('jam_masuk');
        $catatan = $request->getPost('catatan_masuk');
        $lokasi_presensi_id = $request->getPost('lokasi_presensi'); // ID lokasi

        // Mengambil nama lokasi dari database
        $lokasi_presensi_model = new LokasiPresensiModel(); // Pastikan Anda sudah membuat model LokasiModel
        $lokasi_data = $lokasi_presensi_model->find($lokasi_presensi_id);
        $lokasi_presensi_nama = $lokasi_data ? $lokasi_data['nama_lokasi'] : 'Lokasi tidak ditemukan'; // Ganti 'nama_lokasi' dengan nama kolom yang sesuai di tabel lokasi

        $foto_masuk = $request->getPost('foto_masuk');
        $foto_masuk = str_replace('data:image/jpeg;base64,', '', $foto_masuk);
        $foto_masuk = base64_decode($foto_masuk);

        $nama_foto = $id_pegawai . '_' . time() . '.jpg';
        $foto_dir = 'uploads/' . $nama_foto;
        file_put_contents($foto_dir, $foto_masuk);

        $presensi_model = new PresensiModel();
        $db = \Config\Database::connect();

        $db->transStart();
        $presensi_model->insert([
            'id_pegawai' => $id_pegawai,
            'jam_masuk' => $jam_masuk,
            'tanggal_masuk' => $tanggal_masuk,
            'foto_masuk' => $nama_foto,
            'catatan_masuk' => $catatan,
            'lokasi_presensi' => $lokasi_presensi_id // Anda masih menyimpan ID lokasi di sini
        ]);
        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Terjadi kesalahan!");
            session()->setFlashdata('saText', "Gagal melakukan presensi.");
            return redirect()->to(base_url('home'));
        } else {
            session()->setFlashdata('saIcon', 'success');
            session()->setFlashdata('saTitle', "Berhasil melakukan presensi masuk!");
            session()->setFlashdata('saText', ".");

            // Mengirim notifikasi ke Discord dengan nama lokasi
            $lokasi = session()->get('lokasi');
            $message = "**" . session()->get('nama') . "** berhasil melakukan presensi masuk **{$lokasi_presensi_nama}** pada jam **{$jam_masuk} {$lokasi['zona_waktu']}** tanggal **{$tanggal_masuk}**.";
            $this->sendDiscordWebhook($message);

            return redirect()->to(base_url('home'));
        }
    }

    // Fungsi presensi keluar
    public function presensi_keluar($id)
    {
        $latitude_pegawai = (float) $this->request->getPost('latitude_pegawai');
        $longitude_pegawai = (float) $this->request->getPost('longitude_pegawai');
        $latitude_kantor = (float) $this->request->getPost('latitude_kantor');
        $longitude_kantor = (float) $this->request->getPost('longitude_kantor');
        $radius = $this->request->getPost('radius');

        // Menghitung jarak
        $theta = $longitude_pegawai - $longitude_kantor;
        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($theta));
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $jarakPegawai = floor($mil * 1.609344 * 1000); // menggunakan satuan meter

        if ($longitude_pegawai < 1 && $latitude_pegawai < 1) {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi keluar!");
            session()->setFlashdata('saText', "Mohon izinkan akses lokasi anda untuk melakukan presensi.");

            return redirect()->to(base_url('home'));
        }

        if ($jarakPegawai <= $radius) {
            $data = [
                'title' => 'Ambil Foto Selfie',
                'id_presensi' => $id,
                'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
                'jam_keluar' => $this->request->getPost('jam_keluar'),
            ];

            return view('pegawai/ambil_foto_keluar', $data);
        } else {
            session()->setFlashdata('saIcon', 'error');
            session()->setFlashdata('saTitle', "Gagal melakukan presensi keluar!");
            session()->setFlashdata('saText', "Anda berada " . number_format($jarakPegawai - $radius) . " meter diluar radius presensi.");

            return redirect()->to(base_url('home'));
        }
    }

    // Fungsi aksi presensi keluar
    public function presensi_keluar_aksi($id)
    {
        $request = \Config\Services::request();
        $tanggal_keluar = $request->getPost('tanggal_keluar');
        $jam_keluar = $request->getPost('jam_keluar');
        $catatan = $request->getPost('catatan_keluar');

        $foto_keluar = $request->getPost('foto_keluar');
        $foto_keluar = str_replace('data:image/jpeg;base64,', '', $foto_keluar);
        $foto_keluar = base64_decode($foto_keluar);

        $foto_dir = 'uploads/' . $id . '_' . time() . '.jpg';
        $nama_foto = $id . '_' . time() . '.jpg';
        file_put_contents($foto_dir, $foto_keluar);

        $presensi_model = new PresensiModel();
        $db = \Config\Database::connect();

        $db->transStart();
        $presensi_model->update($id, [
            'id' => $id,
            'jam_keluar' => $jam_keluar,
            'tanggal_keluar' => $tanggal_keluar,
            'foto_keluar' => $nama_foto,
            'catatan_keluar' => $catatan
        ]);
        $db->transComplete();

        session()->setFlashdata('saIcon', 'success');
        session()->setFlashdata('saTitle', "Berhasil melakukan presensi keluar!");
        session()->setFlashdata('saText', ".");

        // Kirim notifikasi ke Discord
        $lokasi = session()->get('lokasi');
        $message = "**" . session()->get('nama') . "** berhasil melakukan presensi keluar pada jam **{$jam_keluar} {$lokasi['zona_waktu']}** tanggal **{$tanggal_keluar}**.";
        $this->sendDiscordWebhook($message);


        return redirect()->to(base_url('home'));
    }


    // Fungsi mengirim notifikasi ke Discord
    public function sendDiscordWebhook($message)
    {
        $url = env('app.webhook_url'); // "https://discord.com/api/webhooks/1285443090873716746/f2qI0W_fWhbhsh95cz5T0Jn9FrEjbN0frnxoeISSiojBCix3L54KiHCils-VzFT33K2E";
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
