<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ---------- Publik ----------
$routes->get('/', 'Auth::index');            // redirect sesuai sesi / ke login
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('impor-sampul', 'ImporSampul::index'); // SEMENTARA: dihapus setelah impor sampul live

// ---------- Siswa ----------
$routes->group('siswa', ['filter' => 'role:siswa'], static function ($routes) {
    $routes->get('/', 'Siswa::dashboard');
    $routes->get('jurnal', 'Siswa::jurnal');
    $routes->get('jurnal/baru', 'Siswa::jurnalBaru');
    $routes->post('jurnal', 'Siswa::jurnalSimpan');
    $routes->get('jurnal/edit/(:num)', 'Siswa::jurnalEdit/$1');
    $routes->post('jurnal/update/(:num)', 'Siswa::jurnalUpdate/$1');
    $routes->post('jurnal/hapus/(:num)', 'Siswa::jurnalHapus/$1');
    $routes->get('buku', 'Siswa::buku');
    $routes->get('lencana', 'Siswa::lencana');
    $routes->get('peringkat', 'Siswa::peringkat');
    $routes->get('profil', 'Siswa::profil');
});

// ---------- Guru ----------
$routes->group('guru', ['filter' => 'role:guru'], static function ($routes) {
    $routes->get('/', 'Guru::dashboard');
    $routes->get('verifikasi', 'Guru::verifikasi');
    $routes->post('verifikasi/(:num)', 'Guru::verifikasiSimpan/$1');
    $routes->get('jurnal', 'Guru::semuaJurnal');
    $routes->get('siswa', 'Guru::siswa');
    $routes->get('peringkat', 'Guru::peringkat');
});

// ---------- Katalog Buku (guru & admin) ----------
$routes->group('buku', ['filter' => 'role:guru,admin'], static function ($routes) {
    $routes->get('/', 'Buku::index');
    $routes->get('baru', 'Buku::baru');
    $routes->post('/', 'Buku::simpan');
    $routes->get('edit/(:num)', 'Buku::edit/$1');
    $routes->post('update/(:num)', 'Buku::update/$1');
    $routes->post('hapus/(:num)', 'Buku::hapus/$1');
});

// ---------- Admin ----------
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('users/baru', 'Admin::userBaru');
    $routes->post('users', 'Admin::userSimpan');
    $routes->get('users/edit/(:num)', 'Admin::userEdit/$1');
    $routes->post('users/update/(:num)', 'Admin::userUpdate/$1');
    $routes->post('users/hapus/(:num)', 'Admin::userHapus/$1');
    $routes->get('kelas', 'Admin::kelas');
    $routes->get('kelas/baru', 'Admin::kelasBaru');
    $routes->post('kelas', 'Admin::kelasSimpan');
    $routes->get('kelas/edit/(:num)', 'Admin::kelasEdit/$1');
    $routes->post('kelas/update/(:num)', 'Admin::kelasUpdate/$1');
    $routes->post('kelas/hapus/(:num)', 'Admin::kelasHapus/$1');
    $routes->get('jurnal', 'Admin::jurnal');
    $routes->get('lencana', 'Admin::lencana');
});
