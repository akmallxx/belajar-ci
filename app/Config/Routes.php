<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('logout', 'User::logout');

$routes->get('login', 'User::login');
$routes->post('login_action', 'User::login_action');


$routes->group('api', function($routes) {
    $routes->resource('jabatan', ['controller' => 'Api\Jabatan']);
    $routes->resource('pegawai', ['controller' => 'Api\Pegawai']);
    $routes->resource('ketidakhadiran', ['controller' => 'Api\Ketidakhadiran']);
    $routes->resource('lokasi_presensi', ['controller' => 'Api\LokasiPresensi']);
    $routes->resource('rekap_presensi', ['controller' => 'Api\RekapHarian']);
});


// Admin
$routes->get('admin/home', 'Admin\Home::index', ['filter' => 'AdminFilter']);

$routes->get('admin/jabatan', 'Admin\Jabatan::index', ['filter' => 'AdminFilter']);
$routes->get('admin/jabatan/create', 'Admin\Jabatan::create', ['filter' => 'AdminFilter']);
$routes->post('admin/jabatan/store', 'Admin\Jabatan::store', ['filter' => 'AdminFilter']);
$routes->get('admin/jabatan/edit/(:segment)', 'Admin\Jabatan::edit/$1', ['filter' => 'AdminFilter']);
$routes->post('admin/jabatan/update/(:segment)', 'Admin\Jabatan::update/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/jabatan/delete/(:segment)', 'Admin\Jabatan::delete/$1', ['filter' => 'AdminFilter']);

$routes->get('admin/lokasi_presensi', 'Admin\LokasiPresensi::index', ['filter' => 'AdminFilter']);
$routes->get('admin/lokasi_presensi/create', 'Admin\LokasiPresensi::create', ['filter' => 'AdminFilter']);
$routes->post('admin/lokasi_presensi/store', 'Admin\LokasiPresensi::store', ['filter' => 'AdminFilter']);
$routes->get('admin/lokasi_presensi/edit/(:segment)', 'Admin\LokasiPresensi::edit/$1', ['filter' => 'AdminFilter']);
$routes->post('admin/lokasi_presensi/update/(:segment)', 'Admin\LokasiPresensi::update/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/lokasi_presensi/delete/(:segment)', 'Admin\LokasiPresensi::delete/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/lokasi_presensi/detail/(:segment)', 'Admin\LokasiPresensi::detail/$1', ['filter' => 'AdminFilter']);

$routes->get('admin/data_pegawai', 'Admin\DataPegawai::index', ['filter' => 'AdminFilter']);
$routes->get('admin/data_pegawai/create', 'Admin\DataPegawai::create', ['filter' => 'AdminFilter']);
$routes->post('admin/data_pegawai/store', 'Admin\DataPegawai::store', ['filter' => 'AdminFilter']);
$routes->get('admin/data_pegawai/edit/(:segment)', 'Admin\DataPegawai::edit/$1', ['filter' => 'AdminFilter']);
$routes->post('admin/data_pegawai/update/(:segment)', 'Admin\DataPegawai::update/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/data_pegawai/delete/(:segment)', 'Admin\DataPegawai::delete/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/data_pegawai/detail/(:segment)', 'Admin\DataPegawai::detail/$1', ['filter' => 'AdminFilter']);

$routes->get('admin/rekap_harian', 'Admin\RekapHarian::index', ['filter' => 'AdminFilter']);
$routes->get('admin/rekap_harian/create', 'Admin\RekapHarian::create', ['filter' => 'AdminFilter']);
$routes->post('admin/rekap_harian/store', 'Admin\RekapHarian::store', ['filter' => 'AdminFilter']);
$routes->get('admin/rekap_harian/edit/(:segment)', 'Admin\RekapHarian::edit/$1', ['filter' => 'AdminFilter']);
$routes->post('admin/rekap_harian/update/(:segment)', 'Admin\RekapHarian::update/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/rekap_harian/delete/(:segment)', 'Admin\RekapHarian::delete/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/rekap_harian/detail/(:segment)', 'Admin\RekapHarian::detail/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/rekap_harian/(:num)/(:num)', 'Admin\RekapHarian::index/$1/$2', ['filter' => 'AdminFilter']);


$routes->get('admin/ketidakhadiran', 'Admin\Ketidakhadiran::index', ['filter' => 'AdminFilter']);
$routes->get('admin/ketidakhadiran/create', 'Admin\Ketidakhadiran::create', ['filter' => 'AdminFilter']);
$routes->post('admin/ketidakhadiran/store', 'Admin\Ketidakhadiran::store', ['filter' => 'AdminFilter']);
$routes->get('admin/ketidakhadiran/edit/(:segment)', 'Admin\Ketidakhadiran::edit/$1', ['filter' => 'AdminFilter']);
$routes->post('admin/ketidakhadiran/update/(:segment)', 'Admin\Ketidakhadiran::update/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/ketidakhadiran/delete/(:segment)', 'Admin\Ketidakhadiran::delete/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/ketidakhadiran/detail/(:segment)', 'Admin\Ketidakhadiran::detail/$1', ['filter' => 'AdminFilter']);
$routes->get('admin/ketidakhadiran/statuses/(:segment)/(:segment)', 'Admin\Ketidakhadiran::statuses/$1/$2', ['filter' => 'AdminFilter']);
$routes->get('admin/ketidakhadiran/(:num)/(:num)', 'Admin\Ketidakhadiran::index/$1/$2', ['filter' => 'AdminFilter']);


$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'AdminFilter'], function ($routes) {
    $routes->get('rekap_bulanan', 'RekapBulanan::index');
    $routes->get('rekap_bulanan/create', 'RekapBulanan::create');
    $routes->post('rekap_bulanan/store', 'RekapBulanan::store');
    $routes->get('rekap_bulanan/edit/(:segment)', 'RekapBulanan::edit/$1');
    $routes->post('rekap_bulanan/update/(:segment)', 'RekapBulanan::update/$1');
    $routes->get('rekap_bulanan/delete/(:segment)', 'RekapBulanan::delete/$1');
    $routes->get('rekap_bulanan/exportToCSV', 'RekapBulanan::exportToCSV');
});
// admin end

// Pegawai
$routes->get('home', 'Pegawai\Home::index', ['filter' => 'PegawaiFilter']);

$routes->post('presensi_masuk', 'Pegawai\Home::presensi_masuk', ['filter' => 'PegawaiFilter']);
$routes->post('presensi_masuk_aksi', 'Pegawai\Home::presensi_masuk_aksi', ['filter' => 'PegawaiFilter']);

$routes->post('presensi_keluar/(:segment)', 'Pegawai\Home::presensi_keluar/$1', ['filter' => 'PegawaiFilter']);
$routes->post('presensi_keluar_aksi/(:segment)', 'Pegawai\Home::presensi_keluar_aksi/$1', ['filter' => 'PegawaiFilter']);

// Menampilkan halaman profil pegawai
$routes->get('profile', 'Pegawai\Profile::index', ['filter' => 'PegawaiFilter']);

// Menampilkan halaman edit profil pegawai
$routes->get('profile/edit', 'Pegawai\Profile::edit', ['filter' => 'PegawaiFilter']);

// Mengupdate profil pegawai
$routes->post('profile/update', 'Pegawai\Profile::update', ['filter' => 'PegawaiFilter']);

$routes->get('profile', 'Pegawai\Profile::index', ['filter' => 'PegawaiFilter']);
$routes->get('profile/edit', 'Pegawai\Profile::edit', ['filter' => 'PegawaiFilter']);
$routes->post('profile/update', 'Pegawai\Profile::update', ['Filter' => 'PegawaiFilter']);

$routes->get('rekap_presensi', 'Pegawai\RekapPresensi::index', ['filter' => 'PegawaiFilter']);


$routes->group('', function ($routes) {
    $routes->get('ketidakhadiran', 'Pegawai\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/create', 'Pegawai\Ketidakhadiran::create');
    $routes->post('ketidakhadiran/store', 'Pegawai\Ketidakhadiran::store');
    $routes->get('ketidakhadiran/edit/(:segment)', 'Pegawai\Ketidakhadiran::edit/$1');
    $routes->post('ketidakhadiran/update/(:segment)', 'Pegawai\Ketidakhadiran::update/$1');
    $routes->get('ketidakhadiran/delete/(:segment)', 'Pegawai\Ketidakhadiran::delete/$1');
    $routes->get('ketidakhadiran/detail/(:segment)', 'Pegawai\Ketidakhadiran::detail/$1');
});
// pegawai end
