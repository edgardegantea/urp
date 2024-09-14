<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes) {
// UserController
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users', 'UserController::store');
    $routes->get('users/(:num)', 'UserController::show/$1'); // Corregido
    $routes->get('users/edit/(:num)', 'UserController::edit/$1'); // Corregido
    $routes->put('users/(:num)', 'UserController::update/$1'); // Corregido
    $routes->delete('users/(:num)', 'UserController::delete/$1'); // Corregido
    $routes->get('users/restore/(:num)', 'UserController::restore/$1');

// RoleController
    $routes->get('roles', 'RoleController::index');
    $routes->get('roles/create', 'RoleController::create');
    $routes->post('roles', 'RoleController::store');
    $routes->get('roles/(:num)', 'RoleController::show/$1'); // Corregido
    $routes->get('roles/edit/(:num)', 'RoleController::edit/$1'); // Corregido
    $routes->put('roles/(:num)', 'RoleController::update/$1'); // Corregido
    $routes->delete('roles/(:num)', 'RoleController::delete/$1'); // Corregido

// PermissionController
    $routes->get('permissions', 'PermissionController::index');
    $routes->get('permissions/create', 'PermissionController::create');
    $routes->post('permissions', 'PermissionController::store');
    $routes->get('permissions/(:num)', 'PermissionController::show/$1'); // Corregido
    $routes->get('permissions/edit/(:num)', 'PermissionController::edit/$1'); // Corregido
    $routes->put('permissions/(:num)', 'PermissionController::update/$1'); // Corregido
    $routes->delete('permissions/(:num)', 'PermissionController::delete/$1'); // Corregido

// RolePermissionController
    $routes->get('role_permissions', 'RolePermissionController::index');
    $routes->get('role_permissions/create', 'RolePermissionController::create');
    $routes->post('role_permissions', 'RolePermissionController::store');
// Opcional:
// $routes->get('role_permissions/(:num)/(:num)', 'RolePermissionController::show/$1/$2');
// $routes->get('role_permissions/edit/(:num)/(:num)', 'RolePermissionController::edit/$1/$2');
// $routes->put('role_permissions/(:num)/(:num)', 'RolePermissionController::update/$1/$2');
    $routes->delete('role_permissions/delete/(:num)/(:num)', 'RolePermissionController::delete/$1/$2');

});