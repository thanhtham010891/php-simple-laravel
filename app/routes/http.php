<?php

/**
 * @var Router $router
 */

use Illuminate\Http\Response;
use Illuminate\Routing\Router;

$router->get('/', function (Response $response) {
    return $response->setContent([
        'say' => 'Hello world'
    ]);
});
