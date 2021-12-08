<?php

require './vendor/autoload.php';

use Bramus\Router\Router;
use Symfony\Component\Dotenv\Dotenv;

$env = new Dotenv();
$env->load(__DIR__.'/.env');

$router = new Router();
require 'routes.php';
$router->run();