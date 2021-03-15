<?php

use Illuminate\Support\Facades\Http;

/**
 * @var \Laravel\Lumen\Routing\Router $router
 */

$router->get('/categories', 'TestsController@categories');
$router->get('/products', 'TestsController@products');

$router->get('/php8', 'ExampleController@index');
