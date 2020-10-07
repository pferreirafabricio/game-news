<?php

use Source\Core\Route;

require_once './vendor/autoload.php';
// require_once './source/Core/Headers.php';

/**
 * ROUTE CONFIG
 */
$route = new Route();

/**
 * ROUTES
 */
$route->post('/game', 'GameController@create');
// $route->delete('/game/:id', 'GameController@delete');
//$route->get('/game', 'GameController@index');
//$route->get('/game/:id', 'GameController@getById');
// $route->put('/game/:id', 'GameController@update');
