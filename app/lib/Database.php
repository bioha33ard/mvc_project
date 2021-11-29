<?php

namespace app\lib;

use PDO;

class Database
{
    protected static Database $instance;

    public static function connect(): mixed
    {
        try {
            return new PDO("mysql:host={$_ENV['MYSQL_DATABASE_HOST']};dbname={$_ENV['MYSQL_DATABASE_NAME']}"
                ,$_ENV['MYSQL_DATABASE_USER'],$_ENV['MYSQL_DATABASE_PASSWORD']);
        } catch (\Throwable $throwable) {
            return print_r($throwable->getMessage());
        }
    }

    /**
     * @return Database
     */
    public function getInstance(): Database
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}