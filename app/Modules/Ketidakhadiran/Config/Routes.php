<?php
$routes->group('api', function($routes) {
    $routes->resource('ketidakhadiran', ['controller' => '\Modules\Ketidakhadiran\Controllers\Api\Ketidakhadiran']);
});

$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('ketidakhadiran', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/form', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::form');
    $routes->get('ketidakhadiran/form/(:segment)', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::form/$1');
    $routes->post('ketidakhadiran/save', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::save');
    $routes->post('ketidakhadiran/save/(:segment)', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::save/$1');
    $routes->get('ketidakhadiran/delete/(:segment)', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::delete/$1');
    $routes->get('ketidakhadiran/detail/(:segment)', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::detail/$1');
    $routes->get('ketidakhadiran/statuses/(:segment)/(:segment)', '\Modules\Ketidakhadiran\Controllers\Admin\Ketidakhadiran::statuses/$1/$2');
});

$routes->group('', ['filter' => 'PegawaiFilter'], function ($routes) {
    $routes->get('ketidakhadiran', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/form', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::form');
    $routes->get('ketidakhadiran/form/(:segment)', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::form/$1');
    $routes->post('ketidakhadiran/save', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::save');
    $routes->post('ketidakhadiran/save/(:segment)', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::save/$1');
    $routes->get('ketidakhadiran/delete/(:segment)', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::delete/$1');
    $routes->get('ketidakhadiran/detail/(:segment)', '\Modules\Ketidakhadiran\Controllers\Pegawai\Ketidakhadiran::detail/$1');
});
