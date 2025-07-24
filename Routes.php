<?php

use App\Controllers\ProdukController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login', ['filter' => 'redirect']);
$routes->get('logout', 'AuthController::logout');

$routes->group('produk',['filter' => 'auth'], function ($routes) {
    $routes->get('','ProdukController::index');
    $routes->post('','ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->post('update_status', 'TransaksiController::updateStatus');
$routes->get('download', 'TransaksiController::download');

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);
$routes->get('transaksi/searchKelurahan', 'TransaksiController::searchKelurahan');

$routes->get('faq', 'Home::faq', ['filter' => 'auth']);
$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('transaksi', 'Home::transaksi', ['filter' => 'auth']);
$routes->get('contact', 'Home::contact', ['filter' => 'auth']);

$routes->group('api', function ($routes) {
    $routes->post('monthly', 'ApiController::monthly');
    $routes->post('yearly', 'ApiController::yearly');
});
$routes->group('diskon', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'DiskonController::index'); // List all discounts
    $routes->post('store', 'DiskonController::store'); // Store new discount
    $routes->post('update/(:any)', 'DiskonController::update/$1'); // Update discount
    $routes->get('delete/(:any)', 'DiskonController::delete/$1'); // Delete discount
});