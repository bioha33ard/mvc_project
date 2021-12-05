<?php

namespace app\lib;

use JsonException;
use PDO;
use PDOStatement;
use Throwable;

class Model extends Database
{
    
    
    /**
     * @param  string  $sql
     * @param  array|null  $data
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function query(
        string $sql,
        array $data = null
    ): bool|int|PDOStatement {
        
        $query = $this->connect()->prepare($sql);
        try {
            (isset($data) ? $query->execute($data) : $query->execute());
            $query->setFetchMode(PDO::FETCH_OBJ);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed($throwable->getMessage(), $throwable->getCode(),
                $throwable->getTrace());
        }
    }
    
    /**
     * @param  string  $table
     * @param  array  $where
     *
     * @return bool|PDOStatement
     * @throws JsonException
     */
    public function select(string $table, array $where): bool|PDOStatement
    {
        
        $columns = array_keys($where);
        $condition = $this->where($columns);
        try {
            $query = $this->connect()
                ->prepare("SELECT * FROM $table WHERE $condition");
            $query->execute($where);
            $query->setFetchMode(PDO::FETCH_OBJ);
    
            return $query;
        } catch (Throwable $throwable) {
            return failed($throwable->getMessage(), $throwable->getCode(),
                $throwable->getTrace());
        }
    }
    
    /**
     * @param  string  $table
     * @param  array  $fields
     * @param  array  $where
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function update(
        string $table,
        array $fields,
        array $where
    ): bool|int|PDOStatement {
        
        $data = array_merge($fields, $where);
//        fields
        $fcolumns = $this->buildFieldsString(array_keys($fields));
//        where
        $wcolumns = $this->where(array_keys($where));
        try {
            $query = $this->connect()
                ->prepare("UPDATE $table SET $fcolumns WHERE $wcolumns ");
            $query->execute($data);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed($throwable->getMessage(), $throwable->getCode(),
                $throwable->getTrace());
        }
    }
    
    /**
     * @param  string  $table
     * @param  array  $data
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function insert(string $table, array $data): bool|int|PDOStatement
    {
        
        $fields = implode(' , ', array_keys($data));
        $placeholders = array_map(static fn($items) => " :$items ",
            array_keys($data));
        $values = implode(',', $placeholders);
        try {
            $query = $this->connect()
                ->prepare("INSERT INTO $table ($fields) VALUES ($values)");
            $query->execute($data);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed($throwable->getMessage(), $throwable->getCode(),
                $throwable->getTrace());
        }
    }
    
    /**
     * @param  array  $data
     *
     * @return string
     */
    protected function buildFieldsString(array $data): string
    {
        
        return implode(' , ', $this->buildFields($data));
    }
    
    /**
     * @param  array  $data
     *
     * @return string
     */
    protected function where(array $data): string
    {
        
        $keys = $this->buildFields($data);
        
        return (count($data) > 1) ? implode(' AND ', $keys)
            : implode('', $keys);
    }
    
    /**
     * @param  array  $data
     *
     * @return array
     */
    protected function buildFields(array $data): array
    {
        
        return array_map(static fn($items) => "$items = :$items", $data);
    }
    
}