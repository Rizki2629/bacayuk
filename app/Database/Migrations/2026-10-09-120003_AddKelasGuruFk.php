<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKelasGuruFk extends Migration
{
    public function up()
    {
        // SQLite tidak mendukung menambah FOREIGN KEY lewat ALTER TABLE.
        // Di MySQL (target produksi) constraint ini tetap dibuat;
        // integritas di SQLite dijaga level aplikasi.
        if ($this->db->DBDriver === 'SQLite3') {
            return;
        }
        $this->forge->addColumn('kelas', [
            'CONSTRAINT fk_kelas_guru FOREIGN KEY (guru_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE SET NULL',
        ]);
    }

    public function down()
    {
        $this->forge->dropForeignKey('kelas', 'fk_kelas_guru');
    }
}
