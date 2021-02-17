<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['middleware' => ['auth']], function () use ($router){
    $router->get('users', 'UserController@index');
    $router->post('users', 'UserController@store'); 
});

$router->post('/users/login', 'UserController@getToken');

$router->get('/', function () use ($router) {
    return $router->app->version();
});

