<?php

namespace Modules\LokasiPresensi\Models;

use CodeIgniter\Model;

class LokasiPresensiModel extends Model
{
    protected $table            = 'mst_lokasi_presensi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nama_lokasi',
        'alamat_lokasi',
        'tipe_lokasi',
        'latitude',
        'longitude',
        'radius',
        'zona_waktu',
        'jam_masuk',
        'jam_pulang'
    ];
}


