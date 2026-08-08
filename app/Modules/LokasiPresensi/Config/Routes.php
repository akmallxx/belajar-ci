<?php
$routes->group('api', function($routes) {
    $routes->resource('lokasi_presensi', ['controller' => '\Modules\LokasiPresensi\Controllers\Api\LokasiPresensi']);
});

$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('lokasi_presensi', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::index');
    $routes->get('lokasi_presensi/form', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::form');
    $routes->get('lokasi_presensi/form/(:segment)', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::form/$1');
    $routes->post('lokasi_presensi/save', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::save');
    $routes->post('lokasi_presensi/save/(:segment)', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::save/$1');
    $routes->get('lokasi_presensi/delete/(:segment)', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::delete/$1');
    $routes->get('lokasi_presensi/detail/(:segment)', '\Modules\LokasiPresensi\Controllers\Admin\LokasiPresensi::detail/$1');
});
