<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJurnalBaca extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'siswa_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'buku_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'judul_buku'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'tanggal'           => ['type' => 'DATE'],
            'halaman_dari'      => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'halaman_sampai'    => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'jumlah_halaman'    => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'durasi_menit'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'ringkasan'         => ['type' => 'TEXT', 'null' => true],
            'pesan_cerita'      => ['type' => 'TEXT', 'null' => true],
            'rating'            => ['type' => 'TINYINT', 'constraint' => 3, 'default' => 5],
            'perasaan'          => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true, 'default' => '😊'],
            'status'            => ['type' => 'ENUM', 'constraint' => ['menunggu', 'terverifikasi', 'revisi'], 'default' => 'menunggu'],
            'catatan_guru'      => ['type' => 'TEXT', 'null' => true],
            'diverifikasi_oleh' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'diverifikasi_pada' => ['type' => 'DATETIME', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('siswa_id');
        $this->forge->addKey('status');
        $this->forge->addKey('tanggal');
        $this->forge->addForeignKey('siswa_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buku_id', 'buku', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('diverifikasi_oleh', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('jurnal_baca');
    }

    public function down()
    {
        $this->forge->dropTable('jurnal_baca');
    }
}
