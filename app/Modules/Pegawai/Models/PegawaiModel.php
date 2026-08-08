<?php

namespace Modules\Pegawai\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'mst_pegawai';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nip',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_handphone',
        'jabatan',
        'lokasi_presensi',
        'foto'
    ];

    public function detailPegawai($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('mst_pegawai');
        $builder->select('mst_pegawai.*, mst_users.username, mst_users.status, mst_users.role');
        $builder->join('mst_users', 'mst_users.id_pegawai = mst_pegawai.id');
        $builder->where('mst_pegawai.id', $id);
        return $builder->get()->getRowArray();
    }

    public function editPegawai($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('mst_pegawai');
        $builder->select('mst_pegawai.*, mst_users.username, mst_users.password, mst_users.status, mst_users.role');
        $builder->join('mst_users', 'mst_users.id_pegawai = mst_pegawai.id');
        $builder->where('mst_pegawai.id', $id);
        return $builder->get()->getRowArray();
    }
}



