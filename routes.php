<?php

use app\core\Controller;
use app\Http\Controllers\AppController;
use Bramus\Router\Router;

$router = new Router();

$router->get('/', [Controller::class, 'index']);
$router->get('/user/{id}', [AppController::class, 'index']);