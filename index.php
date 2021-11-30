<?php


require './vendor/autoload.php';

use app\lib\Model;
use Symfony\Component\Dotenv\Dotenv;

$env = new Dotenv();
$env->load(__DIR__ . '/.env');

$data = ['first_name' => 'Maxim'];
$result = (new Model())->select('users', $data);

foreach ($result as $key){
     var_dump($key);
}