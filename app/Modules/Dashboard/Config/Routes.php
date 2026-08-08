<?php
$routes->get('/', '\Modules\Dashboard\Controllers\Home::index');

$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('home', '\Modules\Dashboard\Controllers\Admin\Home::index');
});

$routes->group('admin/api', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('rekap_presensi', '\Modules\Dashboard\Controllers\Admin\Api::rekap_presensi');
    $routes->get('jabatan', '\Modules\Dashboard\Controllers\Admin\Api::jabatan');
    $routes->get('lokasi_presensi', '\Modules\Dashboard\Controllers\Admin\Api::lokasi_presensi');
    $routes->get('pegawai', '\Modules\Dashboard\Controllers\Admin\Api::pegawai');
    $routes->get('ketidakhadiran', '\Modules\Dashboard\Controllers\Admin\Api::ketidakhadiran');
});

$routes->group('', ['filter' => 'PegawaiFilter'], function($routes) {
    $routes->get('home', '\Modules\Dashboard\Controllers\Pegawai\Home::index');
    $routes->post('presensi_masuk', '\Modules\Dashboard\Controllers\Pegawai\Home::presensi_masuk');
    $routes->post('presensi_masuk_aksi', '\Modules\Dashboard\Controllers\Pegawai\Home::presensi_masuk_aksi');
    $routes->post('presensi_keluar/(:segment)', '\Modules\Dashboard\Controllers\Pegawai\Home::presensi_keluar/$1');
    $routes->post('presensi_keluar_aksi/(:segment)', '\Modules\Dashboard\Controllers\Pegawai\Home::presensi_keluar_aksi/$1');
});
