<?php

namespace Modules\Jabatan\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table            = 'mst_jabatan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'jabatan'
    ];
}


