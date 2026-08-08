<?php

namespace Modules\Ketidakhadiran\Models;

use CodeIgniter\Model;

class KetidakhadiranModel extends Model
{
    protected $table = 'dat_ketidakhadiran';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_pegawai',
        'keterangan',
        'tanggal_awal',
        'tanggal_akhir',
        'deskripsi',
        'file',
        'status_pengajuan'
    ];
}


