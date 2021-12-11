<?php

use app\Http\Controllers\AppController;
use Bramus\Router\Router;

$router = new Router();

$router->post('/login', [AppController::class, 'login']);
$router->post('/register', [AppController::class, 'register']);