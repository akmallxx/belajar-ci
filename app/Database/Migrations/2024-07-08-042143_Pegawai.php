<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'jenis_kelamin' => [
                'type' => 'varchar',
                'constraint' => '50',
            ],
            'alamat' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'no_handphone' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'jabatan' => [
                'type' => 'varchar',
                'constraint' => '50',
            ],
            'lokasi_presensi' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'foto' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mst_pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('mst_pegawai');
    }
}

