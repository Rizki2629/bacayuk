<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSampulUrlToBuku extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buku', [
            'sampul_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('buku', 'sampul_url');
    }
}
