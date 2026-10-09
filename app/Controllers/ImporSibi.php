<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Importir sekali jalan: buku non-teks SIBI Kemendikdasmen.
 * Dijaga kunci sederhana; route & controller ini DIHAPUS setelah impor live selesai.
 */
class ImporSibi extends Controller
{
    public function index()
    {
        if ($this->request->getGet('kunci') !== 'sibi-2026-rizki') {
            return $this->response->setStatusCode(403)->setBody('Dilarang.');
        }

        $db = \Config\Database::connect();

        if (! in_array('tautan_pdf', $db->getFieldNames('buku'), true)) {
            \Config\Database::forge()->addColumn('buku', [
                'tautan_pdf' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            ]);
        }

        $rows = json_decode((string) file_get_contents(APPPATH . 'Data/sibi-nonteks.json'), true) ?: [];
        $sudahAda = [];
        foreach ($db->table('buku')->select('judul')->get()->getResultArray() as $r) {
            $sudahAda[mb_strtolower(trim($r['judul']))] = true;
        }

        $baru = [];
        foreach ($rows as $r) {
            if (! isset($sudahAda[mb_strtolower(trim($r['judul']))])) {
                $baru[] = $r;
            }
        }
        foreach (array_chunk($baru, 100) as $chunk) {
            $db->table('buku')->insertBatch($chunk);
        }

        $total = $db->table('buku')->countAllResults();
        return $this->response->setBody('Impor selesai: ' . count($baru) . " buku ditambahkan. Total buku sekarang: {$total}.");
    }
}
