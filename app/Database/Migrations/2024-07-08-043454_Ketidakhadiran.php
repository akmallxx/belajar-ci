<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ketidakhadiran extends Migration
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
            'keterangan' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'deskripsi' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'file' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'status_pengajuan' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pegawai', 'pegawai', 'id'); // add foreign key
        $this->forge->createTable('ketidakhadiran'); // Create table
    }

    public function down()
    {
        $this->forge->dropTable('ketidakhadiran'); // zzzzzzzzzz
    }
}
