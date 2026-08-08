<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Presensi extends Migration
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
            'id_pegawai' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
            ],
            'tanggal_masuk' => [
                'type' => 'date',
            ],
            'jam_masuk' => [
                'type' => 'time',
            ],
            'foto_masuk' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'catatan_masuk' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],
            'tanggal_keluar' => [
                'type' => 'date',
            ],
            'jam_keluar' => [
                'type' => 'time',
            ],
            'foto_keluar' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],
            'catatan_keluar' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],
            'lokasi_presensi' => [
                'type' => 'INT',
                'constraint' => '11'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pegawai', 'mst_pegawai', 'id'); // add foreign key
        $this->forge->createTable('dat_presensi'); // Create table
    }

    public function down()
    {
        $this->forge->dropTable('dat_presensi'); // zzzzzzzzzz
    }
}

