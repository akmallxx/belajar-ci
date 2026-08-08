<?php
$routes->group('api', function($routes) {
    $routes->resource('pegawai', ['controller' => '\Modules\Pegawai\Controllers\Api\Pegawai']);
});

$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('data_pegawai', '\Modules\Pegawai\Controllers\Admin\DataPegawai::index');
    $routes->get('data_pegawai/form', '\Modules\Pegawai\Controllers\Admin\DataPegawai::form');
    $routes->get('data_pegawai/form/(:segment)', '\Modules\Pegawai\Controllers\Admin\DataPegawai::form/$1');
    $routes->post('data_pegawai/save', '\Modules\Pegawai\Controllers\Admin\DataPegawai::save');
    $routes->post('data_pegawai/save/(:segment)', '\Modules\Pegawai\Controllers\Admin\DataPegawai::save/$1');
    $routes->get('data_pegawai/delete/(:segment)', '\Modules\Pegawai\Controllers\Admin\DataPegawai::delete/$1');
    $routes->get('data_pegawai/detail/(:segment)', '\Modules\Pegawai\Controllers\Admin\DataPegawai::detail/$1');
});

$routes->group('', ['filter' => 'PegawaiFilter'], function($routes) {
    $routes->get('profile', '\Modules\Pegawai\Controllers\Pegawai\Profile::index');
    $routes->get('profile/edit', '\Modules\Pegawai\Controllers\Pegawai\Profile::edit');
    $routes->post('profile/update', '\Modules\Pegawai\Controllers\Pegawai\Profile::update');
});
