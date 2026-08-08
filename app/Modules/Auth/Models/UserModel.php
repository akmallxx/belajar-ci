<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'mst_users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_pegawai', 
        'username', 
        'password', 
        'status', 
        'role'
    ];
}


