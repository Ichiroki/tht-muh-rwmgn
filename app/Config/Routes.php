<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('login', static function($routes) {
    $routes->get('/', 'Authentication::login');
    $routes->post('/', 'Authentication::loginSystem');
});

$routes->group('register', static function($routes) {
    $routes->get('/', 'Authentication::register');
    $routes->post('/', 'Authentication::registerSystem');
});