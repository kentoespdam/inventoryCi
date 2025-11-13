<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Auth', 'Auth::index');
$routes->post('/Auth/login', 'Auth::login');
$routes->get('/Auth/logout', 'Auth::logout');
$routes->get('/Dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/Orders', 'Orders::index');
$routes->get('/Cetak/Order/(:num)', 'Cetak\Order::index/$1');
$routes->get('/Orders/Arsip', 'Orders::arsip');

// API
$routes->get('API/JenisBarang', 'API\JenisBarang::index');
$routes->get('API/Pegawai/(:any)', 'API\Pegawai::index/$1');
$routes->get('API/Satker', 'API\Satker::index');
$routes->get('API/Inventory/(:any)/master', 'API\Inventory::master/$1');
$routes->get('API/Inventory/(:any)/(:any)', 'API\Inventory::index/$1/$2');
$routes->get('API/DetailOrder/(:any)/(:any)/(:any)/(:any)', 'API\DetailOrder::index/$1/$2/$3/$4');

$routes->get('API/Persediaan/Order/arsip/(:any)/(:any)', 'API\Persediaan\Order::arsip/$1/$2');
$routes->resource('API/Persediaan/Order');
// API


