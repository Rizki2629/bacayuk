<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Pemakaian di routes: ['filter' => 'role:admin,guru']
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('role');
        if (! $role) {
            return redirect()->to('/login');
        }
        if ($arguments !== null && $arguments !== [] && ! in_array($role, $arguments, true)) {
            $tujuan = ['admin' => '/admin', 'guru' => '/guru', 'siswa' => '/siswa'][$role] ?? '/';
            return redirect()->to($tujuan)->with('error', 'Kamu tidak punya akses ke halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
