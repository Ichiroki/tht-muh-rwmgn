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

    $routes->get('logout', 'Authentication::logoutSystem');

    $routes->group('/units', function($routes) {
        $routes->get('/', 'Units::index');
        
        $routes->get('create', 'Units::create');
        $routes->post('create', 'Units::store');

        $routes->get('edit/(:segment)', 'Units::edit/$1');
        $routes->patch('edit/(:segment)', 'Units::update/$1');

        $routes->delete('delete/(:segment)', 'Units::delete/$1');
    });

    $routes->group('/rapb', function($routes) {
        $routes->get('/', 'RAPB::index');
        
        $routes->get('create', 'RAPB::create');
        $routes->post('create', 'RAPB::store');

        $routes->get('edit/(:segment)', 'RAPB::edit/$1');
        $routes->patch('edit/(:segment)', 'RAPB::update/$1');

        $routes->delete('delete/(:segment)', 'RAPB::delete/$1');
    });

    $routes->group('/cashflow', function($routes) {
        $routes->get('/', 'Cashflow::index');
        
        $routes->get('create', 'Cashflow::create');
        $routes->post('create', 'Cashflow::store');

        $routes->get('edit/(:segment)', 'Cashflow::edit/$1');
        $routes->patch('edit/(:segment)', 'Cashflow::update/$1');

        $routes->delete('delete/(:segment)', 'Cashflow::delete/$1');
    });
});
