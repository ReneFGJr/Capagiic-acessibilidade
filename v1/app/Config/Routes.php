<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group(
    'places',
    function ($routes) {
        $routes->post('save', 'Places::save');
        $routes->get('(:num)', 'Places::index/$1');
        $routes->get('', 'Places::index');
        //$routes->put('places/(:num)', 'Api\Places::update/$1');
        //$routes->delete('places/(:num)', 'Api\Places::delete/$1');
    });

$routes->group(
    'form',
    function ($routes) {
        $routes->post('save', 'Form::save');
        $routes->get('(:num)', 'Form::index/$1');
        $routes->get('', 'Form::index');
        //$routes->put('places/(:num)', 'Api\Places::update/$1');
        //$routes->delete('places/(:num)', 'Api\Places::delete/$1');
    }
);


$routes->group('api', function ($routes) {
    $routes->get('users/(:alpha)', 'Api\Users::index/$1');
    $routes->post('users/(:alpha)/', 'Api\Users::index/$1');
    $routes->get('users', 'Api\Users::index');
    //$routes->put('users/(:num)', 'Api\Users::update/$1');
    //$routes->delete('users/(:num)', 'Api\Users::delete/$1');
});
