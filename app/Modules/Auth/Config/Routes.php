<?php
$routes->get('logout', '\Modules\Auth\Controllers\User::logout');
$routes->get('login', '\Modules\Auth\Controllers\User::login');
$routes->post('login_action', '\Modules\Auth\Controllers\User::login_action');
