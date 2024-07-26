<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_pegawai', 
        'username', 
        'password', 
        'status', 
        'role'
    ];
}
