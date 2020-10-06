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
Route::get('/get/game/:id', 'GameController@index');
