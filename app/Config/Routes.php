<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('logout', 'User::logout');

$routes->get('login', 'User::login');
$routes->post('login_action', 'User::login_action');


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


// Pegawai
$routes->get('pegawai/home', 'Pegawai\Home::index', ['filter' => 'PegawaiFilter']);

$routes->post('pegawai/presensi_masuk', 'Pegawai\Home::presensi_masuk', ['filter' => 'PegawaiFilter']);
$routes->post('pegawai/presensi_masuk_aksi', 'Pegawai\Home::presensi_masuk_aksi', ['filter' => 'PegawaiFilter']);

$routes->post('pegawai/presensi_keluar/(:segment)', 'Pegawai\Home::presensi_keluar/$1', ['filter' => 'PegawaiFilter']);
$routes->post('pegawai/presensi_keluar_aksi/(:segment)', 'Pegawai\Home::presensi_keluar_aksi/$1', ['filter' => 'PegawaiFilter']);
