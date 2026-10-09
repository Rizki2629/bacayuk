<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
  private function tujuanRole(string $role): string
  {
    return ['admin' => '/admin', 'guru' => '/guru', 'siswa' => '/siswa'][$role] ?? '/login';
  }

  public function index()
  {
    if (session()->get('user_id')) {
      return redirect()->to($this->tujuanRole((string) session()->get('role')));
    }
    return redirect()->to('/login');
  }

  public function login()
  {
    if (session()->get('user_id')) {
      return redirect()->to($this->tujuanRole((string) session()->get('role')));
    }
    return view('auth/login');
  }

  public function doLogin()
  {
    $username = trim((string) $this->request->getPost('username'));
    $password = (string) $this->request->getPost('password');

    $user = model(UserModel::class)->byUsername($username);

    if ($user === null || ! password_verify($password, $user['password_hash'])) {
      return redirect()->back()->withInput()->with('error', 'Username atau kata sandi salah. Coba lagi ya.');
    }
    if ((int) $user['is_active'] !== 1) {
      return redirect()->back()->with('error', 'Akun ini sedang dinonaktifkan. Hubungi admin ya.');
    }

    session()->set([
      'user_id' => $user['id'],
      'nama'   => $user['nama'],
      'username' => $user['username'],
      'role'   => $user['role'],
      'kelas_id' => $user['kelas_id'],
      'avatar'  => $user['avatar'] ?: '🦊',
    ]);

    return redirect()->to($this->tujuanRole($user['role']))
      ->with('success', 'Halo, ' . $user['nama'] . '! Selamat datang di BacaYuk! ');
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to('/login')->with('success', 'Sampai jumpa! Terus semangat membaca ya. 👋');
  }
}
