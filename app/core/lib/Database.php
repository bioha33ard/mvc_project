<?php

namespace app\core\lib;

use JsonException;
use PDO;
use Throwable;

class Database
{
    
    protected PDO $connect;
    
    protected static Database $instance;
    
    /**
     * @throws JsonException
     */
    public function connect(): PDO|int
    {
        
        try {
            $this->connect = new PDO("mysql:host={$_ENV['MYSQL_DATABASE_HOST']};dbname={$_ENV['MYSQL_DATABASE_NAME']}",
                $_ENV['MYSQL_DATABASE_USER'], $_ENV['MYSQL_DATABASE_PASSWORD']);
            
            return $this->connect;
        } catch (Throwable $throwable) {
            return failed($throwable->getMessage(), $throwable->getCode(),
                $throwable->getTrace());
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