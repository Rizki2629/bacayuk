<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBuku extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'penulis'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'penerbit'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'genre'          => ['type' => 'ENUM', 'constraint' => ['Dongeng', 'Sains', 'Puisi', 'Cerita Rakyat', 'Komik', 'Novel Anak', 'Agama', 'Lainnya'], 'default' => 'Dongeng'],
            'jumlah_halaman' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'warna_sampul'   => ['type' => 'VARCHAR', 'constraint' => 7, 'default' => '#6C4CF1'],
            'ikon'           => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true, 'default' => '📚'],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'ditambah_oleh'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ditambah_oleh', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}
