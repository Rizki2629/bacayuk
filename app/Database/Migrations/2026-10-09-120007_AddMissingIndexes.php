<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingIndexes extends Migration
{
    public function up()
    {
        // Index yang belum eksplisit di migrasi sebelumnya:
        // - jurnal_baca(buku_id): sebelumnya hanya tertutup FOREIGN KEY
        //   (MySQL otomatis membuat index untuk FK, SQLite tidak) — diselaraskan
        //   dengan nama index di database/bacayuk.sql.
        // - users(kelas_id): di bacayuk.sql sudah ada idx_users_kelas,
        //   di jalur migrasi sebelumnya hanya tertutup FOREIGN KEY.
        // Index lain yang umum dicari (jurnal_baca.siswa_id/status/tanggal,
        // user_lencana.user_id, users.username) SUDAH ada sejak migrasi awal
        // (addKey / UNIQUE), jadi tidak diduplikat di sini.
        $this->forge->addKey('buku_id', false, false, 'idx_jurnal_buku');
        $this->forge->processIndexes('jurnal_baca');

        $this->forge->addKey('kelas_id', false, false, 'idx_users_kelas');
        $this->forge->processIndexes('users');
    }

    public function down()
    {
        $this->forge->dropKey('jurnal_baca', 'idx_jurnal_buku');
        $this->forge->dropKey('users', 'idx_users_kelas');
    }
}
