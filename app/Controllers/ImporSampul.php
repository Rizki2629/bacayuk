<?php

namespace App\Controllers;

use App\Models\BukuModel;
use Config\Database;

/**
 * Importir sekali jalan: mengisi buku.sampul_url dari app/Data/sibi-sampul.json
 * (pasangan judul -> URL sampul asli SIBI Kemendikdasmen).
 * Idempoten: hanya buku yang sampul_url-nya masih kosong yang diisi.
 * SEMENTARA — route + controller ini dihapus setelah impor live selesai.
 */
class ImporSampul extends BaseController
{
    public function index()
    {
        if ($this->request->getGet('kunci') !== 'sampul-2026-rizki') {
            return $this->response->setStatusCode(403)->setBody('Dilarang: kunci salah.');
        }

        $db = Database::connect();

        // Tambah kolom bila migrasi belum sempat dijalankan.
        if (! $db->fieldExists('sampul_url', 'buku')) {
            Database::forge()->addColumn('buku', [
                'sampul_url' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            ]);
        }

        $peta = json_decode((string) file_get_contents(APPPATH . 'Data/sibi-sampul.json'), true) ?: [];

        $norm = static fn ($s) => mb_strtolower(trim((string) preg_replace('/\s+/', ' ', (string) $s)));

        $indeks = [];
        foreach ($peta as $judul => $url) {
            $indeks[$norm($judul)] = $url;
        }

        $buku  = model(BukuModel::class);
        $semua = $buku->select('id, judul, sampul_url')->findAll();

        $terisi = $sudah = $takCocok = 0;
        foreach ($semua as $b) {
            if (! empty($b['sampul_url'])) {
                $sudah++;
                continue;
            }
            $url = $indeks[$norm($b['judul'])] ?? null;
            if ($url !== null) {
                $buku->update((int) $b['id'], ['sampul_url' => $url]);
                $terisi++;
            } else {
                $takCocok++;
            }
        }

        return $this->response->setBody(
            "Impor sampul selesai: {$terisi} buku terisi sampul_url. "
            . "Sudah ada sebelumnya: {$sudah}. Tidak cocok judulnya: {$takCocok}. "
            . 'Total buku: ' . count($semua) . '.'
        );
    }
}
