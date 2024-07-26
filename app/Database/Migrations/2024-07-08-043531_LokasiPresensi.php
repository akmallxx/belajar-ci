<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LokasiPresensi extends Migration
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
            'nama_lokasi' => [
                'type'       => 'varchar',
                'constraint' => '255',
            ],
            'alamat_lokasi' => [
                'type'       => 'varchar',
                'constraint' => '255',
            ],
            'tipe_lokasi' => [
                'type'       => 'varchar',
                'constraint' => '255',
            ],
            'latitude' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'longitude' => [
                'type'       => 'varchar',
                'constraint' => '255',
            ],
            'radius' => [
                'type' => 'int',
            ],
            'zona_waktu' => [
                'type' => 'varchar',
                'constraint' => '4'
            ],
            'jam_masuk' => [
                'type' => 'time',
            ],
            'jam_pulang' => [
                'type' => 'time',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lokasi_presensi'); // Create table
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_presensi'); // zzzzzzzzzz
    }
}
