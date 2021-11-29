<?php

namespace app\lib;

use PDO;
use Throwable;

class Database
{
    protected static Database $instance;

    /**
     * @throws \JsonException
     */
    public static function connect(): PDO|int
    {
        try {
            return new PDO(
                "mysql:host={$_ENV['MYSQL_DATABASE_HOST']};dbname={$_ENV['MYSQL_DATABASE_NAME']}"
                , $_ENV['MYSQL_DATABASE_USER'], $_ENV['MYSQL_DATABASE_PASSWORD']
            );
        } catch (Throwable $throwable) {
            return failed(
                $throwable->getMessage(),
                $throwable->getCode(),
                $throwable->getTrace()
            );
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