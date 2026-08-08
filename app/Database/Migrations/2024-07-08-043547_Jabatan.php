<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jabatan extends Migration
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
            'jabatan' => [
                'type'       => 'varchar',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mst_jabatan'); // Create table
    }

    public function down()
    {
        $this->forge->dropTable('mst_jabatan'); // zzzzzzzzzz
    }
}

