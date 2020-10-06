<?php

use Source\Core\Route;

require_once './vendor/autoload.php';
// require_once './source/Core/Headers.php';


/**
 * ROUTE CONFIG
 */
Route::$needle = "@";

/**
 * ROUTES
 */
Route::get('/game/:id', 'GameController@getById');
Route::get('/game', 'GameController@index');
Route::post('/game', 'GameController@create');
Route::put('/game/:id', 'GameController@update');
Route::delete('/game:id', 'GameController@delete');
