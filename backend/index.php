<?php

use Source\Core\Route;

require_once './vendor/autoload.php';
//require_once './source/Core/Headers.php';

/**
 * ROUTE CONFIG
 */
$route = new Route();

/**
 * ROUTES
 */
$route->get('/game/:id', 'GameController@getById');
$route->get('/game', 'GameController@index');
$route->post('/game', 'GameController@create');
$route->put('/game/:id', 'GameController@update');
$route->delete('/game/:id', 'GameController@delete');
