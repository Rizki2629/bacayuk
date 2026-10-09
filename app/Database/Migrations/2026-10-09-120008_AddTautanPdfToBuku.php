<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTautanPdfToBuku extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buku', [
            'tautan_pdf' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('buku', 'tautan_pdf');
    }
}
