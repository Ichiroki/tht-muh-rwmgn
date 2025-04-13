<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Auth - tidak perlu auth filter karena untuk login/register
    $routes->post('login', 'API/Authentication::loginSystem');
    $routes->post('register', 'API/Authentication::registerSystem');

    $routes->group('', ['filter' => 'auth'], function($routes) {

        // Logout
        $routes->post('logout', 'API/Authentication::logoutSystem');

        // Units
        $routes->get('units', 'API/Units::index');
        $routes->post('units', 'API/Units::store');
        $routes->get('units/(:segment)', 'API/Units::show/$1');
        $routes->put('units/(:segment)', 'API/Units::update/$1');
        $routes->delete('units/(:segment)', 'API/Units::delete/$1');

        // Users
        $routes->get('users', 'API/Users::index');
        $routes->post('users', 'API/Users::store');
        $routes->get('users/(:segment)', 'API/Users::show/$1');
        $routes->put('users/(:segment)', 'API/Users::update/$1');
        $routes->delete('users/(:segment)', 'API/Users::delete/$1');

        // Roles
        $routes->get('roles', 'API/Roles::index');
        $routes->post('roles', 'API/Roles::store');
        $routes->get('roles/(:segment)', 'API/Roles::show/$1');
        $routes->put('roles/(:segment)', 'API/Roles::update/$1');
        $routes->delete('roles/(:segment)', 'API/Roles::delete/$1');

        // RAPB
        $routes->get('rapb', 'API/RAPB::index');
        $routes->post('rapb', 'API/RAPB::store');
        $routes->get('rapb/(:segment)', 'API/RAPB::show/$1');
        $routes->put('rapb/(:segment)', 'API/RAPB::update/$1');
        $routes->delete('rapb/(:segment)', 'API/RAPB::delete/$1');

        // Cashflow
        $routes->get('cashflow', 'API/Cashflow::index');
        $routes->post('cashflow', 'API/Cashflow::store');
        $routes->get('cashflow/(:segment)', 'API/Cashflow::show/$1');
        $routes->put('cashflow/(:segment)', 'API/Cashflow::update/$1');
        $routes->delete('cashflow/(:segment)', 'API/Cashflow::delete/$1');

        // Chart routes
        $routes->get('cashflow/chart/category', 'API/Chart::getChartData');
        $routes->get('cashflow/chart/month', 'API/Chart::getChartByMonth');
        $routes->get('cashflow/chart/unit', 'API/Chart::getChartByUnit');
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
