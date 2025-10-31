<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/places', 'Places::index');
$routes->post('/places/save', 'Places::save');

$routes->group('api', function ($routes) {
    $routes->get('users/(:alpha)', 'Api\Users::index/$1');
    $routes->post('users/(:alpha)/', 'Api\Users::index/$1');
    $routes->get('users', 'Api\Users::index');
    //$routes->put('users/(:num)', 'Api\Users::update/$1');
    //$routes->delete('users/(:num)', 'Api\Users::delete/$1');
});
