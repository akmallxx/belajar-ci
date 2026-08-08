<?php
$routes->group('api', function($routes) {
    $routes->resource('jabatan', ['controller' => '\Modules\Jabatan\Controllers\Api\Jabatan']);
});

$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('jabatan', '\Modules\Jabatan\Controllers\Admin\Jabatan::index');
    $routes->get('jabatan/form', '\Modules\Jabatan\Controllers\Admin\Jabatan::form');
    $routes->get('jabatan/form/(:segment)', '\Modules\Jabatan\Controllers\Admin\Jabatan::form/$1');
    $routes->post('jabatan/save', '\Modules\Jabatan\Controllers\Admin\Jabatan::save');
    $routes->post('jabatan/save/(:segment)', '\Modules\Jabatan\Controllers\Admin\Jabatan::save/$1');
    $routes->get('jabatan/delete/(:segment)', '\Modules\Jabatan\Controllers\Admin\Jabatan::delete/$1');
});
