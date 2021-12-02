<?php


require './vendor/autoload.php';

use app\lib\Model;
use Symfony\Component\Dotenv\Dotenv;

$env = new Dotenv();
$env->load(__DIR__ . '/.env');

$result = (new Model())->update('users', ['id' => 5], $data);
