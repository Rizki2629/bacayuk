<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLencana extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'         => ['type' => 'VARCHAR', 'constraint' => 80],
            'deskripsi'    => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'ikon'         => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => '🏅'],
            'syarat_tipe'  => ['type' => 'ENUM', 'constraint' => ['total_buku', 'total_halaman', 'total_menit', 'streak', 'total_jurnal']],
            'syarat_nilai' => ['type' => 'INT', 'constraint' => 11],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lencana');

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'lencana_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'diraih_pada' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'lencana_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lencana_id', 'lencana', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_lencana');
    }

    public function down()
    {
        $this->forge->dropTable('user_lencana');
        $this->forge->dropTable('lencana');
    }
}
