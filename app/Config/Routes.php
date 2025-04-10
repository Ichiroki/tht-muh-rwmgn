<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('/', ['filter' => 'guest'], function($routes) {
    $routes->group('login', static function($routes) {
        $routes->get('/', 'Authentication::login');
        $routes->post('/', 'Authentication::loginSystem');
    });
    
    $routes->group('register', static function($routes) {
        $routes->get('/', 'Authentication::register');
        $routes->post('/', 'Authentication::registerSystem');
    });
});

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Pages::dashboard');

    $routes->group('/rapb', function($routes) {
        $routes->get('/', 'RAPB::index');
        
        $routes->get('create', 'RAPB::create');
        $routes->post('create', 'RAPB::store');
    });
});
