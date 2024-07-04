<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');

// Komik 
$routes->get('/komik/create', 'Komik::create');

$routes->get('/komik/edit/(:segment)', 'Komik::edit/$1');

$routes->post('/komik/save', 'Komik::save');

$routes->delete('/komik/(:num)', 'Komik::delete/$1');

$routes->get('/komik/(:any)', 'Komik::detail/$1');

// --------------------------------------------------------------------------------------------------------------------

// Anggota

$routes->get('/anggota/create', 'Anggota::create');

$routes->get('/anggota/edit/(:segment)', 'Anggota::edit/$1');

$routes->post('/anggota/save', 'Anggota::save');

$routes->delete('/anggota/(:num)', 'Anggota::delete/$1');

$routes->get('/anggota/(:any)', 'Anggota::detail/$1');

// --------------------------------------------------------------------------------------------------------------------

// Pinjam

$routes->get('/pinjam', 'Pinjam::index');

$routes->get('/pinjam/create', 'Pinjam::create');

$routes->post('/pinjam/save', 'Pinjam::save');

$routes->get('/pinjam/return/(:segment)', 'Pinjam::return/$1');

// --------------------------------------------------------------------------------------------------------------------

// Login




$routes->setAutoRoute(true);
