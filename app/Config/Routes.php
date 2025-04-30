<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api\API'], function($routes) {
    // Auth - tidak perlu auth filter karena untuk login/register
    $routes->post('login', 'Authentication::loginSystem');
    $routes->post('register', 'Authentication::registerSystem');

    $routes->group('', ['filter' => 'auth'], function($routes) {

        // Logout
        $routes->post('logout', 'Authentication::logoutSystem');

        // Units
        $routes->get('units', 'Units::index');
        $routes->post('units', 'Units::store');
        $routes->get('units/(:segment)', 'Units::show/$1');
        $routes->put('units/(:segment)', 'Units::update/$1');
        $routes->delete('units/(:segment)', 'Units::delete/$1');

        // Users
        $routes->get('users', 'Users::index');
        $routes->post('users', 'Users::store');
        $routes->get('users/(:segment)', 'Users::show/$1');
        $routes->put('users/(:segment)', 'Users::update/$1');
        $routes->delete('users/(:segment)', 'Users::delete/$1');

        // Roles
        $routes->get('roles', 'Roles::index');
        $routes->post('roles', 'Roles::store');
        $routes->get('roles/(:segment)', 'Roles::show/$1');
        $routes->put('roles/(:segment)', 'Roles::update/$1');
        $routes->delete('roles/(:segment)', 'Roles::delete/$1');

        // RAPB
        $routes->get('rapb', 'RAPB::index');
        $routes->post('rapb', 'RAPB::store');
        $routes->get('rapb/(:segment)', 'RAPB::show/$1');
        $routes->put('rapb/(:segment)', 'RAPB::update/$1');
        $routes->delete('rapb/(:segment)', 'RAPB::delete/$1');

        // Cashflow
        $routes->get('cashflow', 'Cashflow::index');
        $routes->post('cashflow', 'Cashflow::store');
        $routes->get('cashflow/(:segment)', 'Cashflow::show/$1');
        $routes->put('cashflow/(:segment)', 'Cashflow::update/$1');
        $routes->delete('cashflow/(:segment)', 'Cashflow::delete/$1');

        // Chart routes
        $routes->get('cashflow/chart/category', 'Chart::getChartData');
        $routes->get('cashflow/chart/month', 'Chart::getChartByMonth');
        $routes->get('cashflow/chart/unit', 'Chart::getChartByUnit');
    });
});

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

    $routes->group('/tata-cara', function($routes) {
        $routes->get('/', 'Howto::index');

        $routes->get('apa-itu-rapb', "Howto::whatIsRAPB");
        $routes->get('cara-kerja-rapb', "Howto::howDoesRAPBWork");
    });

    $routes->group('/units', function($routes) {
        $routes->get('/', 'Units::index');
        
        $routes->get('create', 'Units::create');
        $routes->post('create', 'Units::store');

        $routes->get('edit/(:segment)', 'Units::edit/$1');
        $routes->patch('edit/(:segment)', 'Units::update/$1');

        $routes->delete('delete/(:segment)', 'Units::delete/$1');
    });

    $routes->group('/users', function($routes) {
        $routes->get('/', 'Users::index');
        
        $routes->get('create', 'Users::create');
        $routes->post('create', 'Users::store');

        $routes->get('edit/(:segment)', 'Users::edit/$1');
        $routes->patch('edit/(:segment)', 'Users::update/$1');

        $routes->delete('delete/(:segment)', 'Users::delete/$1');
    });

    $routes->group('/roles', function($routes) {
        $routes->get('/', 'Roles::index');
        
        $routes->get('create', 'Roles::create');
        $routes->post('create', 'Roles::store');

        $routes->get('edit/(:segment)', 'Roles::edit/$1');
        $routes->patch('edit/(:segment)', 'Roles::update/$1');

        $routes->delete('delete/(:segment)', 'Roles::delete/$1');
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

        $routes->get('category', 'ChartController::getChartData');
        $routes->get('month', 'ChartController::getChartByMonth');
        $routes->get('unit', 'ChartController::getChartByUnit');
    });
});
