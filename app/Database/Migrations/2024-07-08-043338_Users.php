<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'username' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'role' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pegawai', 'pegawai', 'id'); // add foreign key
        $this->forge->createTable('users'); // Create table
    }

    public function down()
    {
        $this->forge->dropTable('users'); // zzzzzzzzzz
    }
}
