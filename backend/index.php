<?php

require_once './vendor/autoload.php';
// require_once './source/Core/Headers.php';

use CoffeeCode\Router\Router;

#region My first try of make a router

/**
 * ROUTE CONFIG
 */
// $route = new Route();

/**
 * ROUTES
 */
// $route->get('/game', 'GameController@index');
// $route->get('/game/:id', 'GameController@getById');
// $route->post('/game', 'GameController@create');
// $route->put('/game/:id', 'GameController@update');
// $route->delete('/game/:id', 'GameController@delete');

#endregion

/**
 * ROUTE CONFIG
 */
$router = new Router(CONF_BASE_URL, '@');

/**
 * ROUTES
 */
$router->namespace('Source\Controllers')->group('game');
$router->get('/', 'GameController@index');
$router->get('/{id}', 'GameController@getById');
$router->post('/', 'GameController@create');
$router->put('/{id}', 'GameController@update');
$router->delete('/{id}', 'GameController@delete');

$router->dispatch();

if ($router->error()) {
    $router->redirect('/');
}