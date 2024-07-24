<?php

namespace App\Models;

use CodeIgniter\Model;

class RekapHarianModel extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_pegawai', 'tanggal_masuk', 'jam_masuk', 'tanggal_keluar', 'jam_keluar', 'foto_keluar'
    ];

    public function getRekapHarian($tanggal)
    {
        $this->select('presensi.*, pegawai.nip, pegawai.nama, pegawai.lokasi_presensi');
        $this->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $this->where('presensi.tanggal_masuk', $tanggal);
        return $this->findAll();
    }

    public function getBatasWaktu($id_lokasi)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lokasi_presensi');
        $builder->select('jam_masuk, jam_pulang');
        $builder->where('id', $id_lokasi);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function calculateDelay($jam_masuk, $batas_masuk)
    {
        $jam_masuk_dt = new \DateTime($jam_masuk);
        $batas_masuk_dt = new \DateTime($batas_masuk);

        if ($jam_masuk_dt > $batas_masuk_dt) {
            $interval = $jam_masuk_dt->diff($batas_masuk_dt);
            return $interval->format('Terlambat %h jam %i menit');
        } else {
            return 'Tepat Waktu';
        }
    }
}
