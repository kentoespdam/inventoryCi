<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

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

$routes->get('/Order', 'Order::index');
$routes->get('/Cetak/Order/(:num)', 'Cetak\Order::index/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
