<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group(
    'admin',
    function ($routes) {
        $routes->get('prompt', 'Admin::prompt');
    }
);

$routes->group(
    'places',
    function ($routes) {
        $routes->get('confirm', 'Places::confirmAndBackProfile');
        $routes->post('save', 'Places::save');
        $routes->get('(:num)', 'Places::index/$1');
        $routes->get('', 'Places::index');
        //$routes->put('places/(:num)', 'Api\Places::update/$1');
        //$routes->delete('places/(:num)', 'Api\Places::delete/$1');
    });

$routes->group(
    'form',
    function ($routes) {
        $routes->post('answer-ajax', 'Form::saveAnswerAjax');
        $routes->post('save', 'Form::save');
        $routes->get('(:num)/(:num)', 'Form::index/$1/$2');
        $routes->get('(:num)', 'Form::index/$1/01');
        $routes->get('', 'Form::selectForm');
        //$routes->put('places/(:num)', 'Api\Places::update/$1');
        //$routes->delete('places/(:num)', 'Api\Places::delete/$1');
    }
);

$routes->group(
    'reports',
    function ($routes) {
        $routes->get('', 'Reports::index');
    }
);

$routes->get('avaliations', 'Avaliations::index');
$routes->get('images', 'Images::index');
$routes->get('images/upload', 'Images::upload');
$routes->post('images/upload', 'Images::storeUpload');

$routes->get('about', 'About::index');

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::attemptForgotPassword');
});

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('cadastro', 'Auth::register');
$routes->post('cadastro', 'Auth::attemptRegister');
$routes->get('recuperar-senha', 'Auth::forgotPassword');
$routes->post('recuperar-senha', 'Auth::attemptForgotPassword');
$routes->get('perfil', 'Auth::profile');
$routes->get('logout', 'Auth::logout');


$routes->group('api', function ($routes) {
    $routes->get('users/(:alpha)', 'Api\Users::index/$1');
    $routes->post('users/(:alpha)/', 'Api\Users::index/$1');
    $routes->get('users', 'Api\Users::index');
    //$routes->put('users/(:num)', 'Api\Users::update/$1');
    //$routes->delete('users/(:num)', 'Api\Users::delete/$1');
});
