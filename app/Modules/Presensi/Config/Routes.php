<?php
$routes->group('api', function($routes) {
    $routes->resource('rekap_presensi', ['controller' => '\Modules\Presensi\Controllers\Api\RekapHarian']);
});

$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('rekap_harian', '\Modules\Presensi\Controllers\Admin\RekapHarian::index');
    $routes->get('rekap_harian/form', '\Modules\Presensi\Controllers\Admin\RekapHarian::form');
    $routes->get('rekap_harian/form/(:segment)', '\Modules\Presensi\Controllers\Admin\RekapHarian::form/$1');
    $routes->post('rekap_harian/save', '\Modules\Presensi\Controllers\Admin\RekapHarian::save');
    $routes->post('rekap_harian/save/(:segment)', '\Modules\Presensi\Controllers\Admin\RekapHarian::save/$1');
    $routes->get('rekap_harian/delete/(:segment)', '\Modules\Presensi\Controllers\Admin\RekapHarian::delete/$1');
    $routes->get('rekap_harian/detail/(:segment)', '\Modules\Presensi\Controllers\Admin\RekapHarian::detail/$1');
    $routes->get('rekap_harian/(:num)/(:num)', '\Modules\Presensi\Controllers\Admin\RekapHarian::index/$1/$2');
    
    $routes->group('', ['namespace' => '\Modules\Presensi\Controllers\Admin'], function ($routes) {
        $routes->get('rekap_bulanan', 'RekapBulanan::index');
        $routes->get('rekap_bulanan/create', 'RekapBulanan::create');
        $routes->post('rekap_bulanan/store', 'RekapBulanan::store');
        $routes->get('rekap_bulanan/edit/(:segment)', 'RekapBulanan::edit/$1');
        $routes->post('rekap_bulanan/update/(:segment)', 'RekapBulanan::update/$1');
        $routes->get('rekap_bulanan/delete/(:segment)', 'RekapBulanan::delete/$1');
        $routes->get('rekap_bulanan/exportToCSV', 'RekapBulanan::exportToCSV');
    });
});

$routes->group('', ['filter' => 'PegawaiFilter'], function($routes) {
    $routes->get('rekap_presensi', '\Modules\Presensi\Controllers\Pegawai\RekapPresensi::index');
});
