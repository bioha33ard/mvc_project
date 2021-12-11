<?php

namespace app\core\lib;

use app\core\lib\QueryBuilder\BuildFields;
use JsonException;
use PDO;
use PDOStatement;
use Throwable;

abstract class Model extends Database
{
    
    use BuildFields;
    
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
     * @return array|false|PDOStatement
     * @throws JsonException
     */
    public function select(string $table, array $where): bool|array|PDOStatement
    {
        
        $columns = array_keys($where);
        $condition = $this->where($columns);
        try {
            $query = $this->connect()
                ->prepare("SELECT * FROM $table WHERE $condition");
            $query->execute($where);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed((array)$throwable->getMessage(),
                $throwable->getCode(), $throwable->getTrace());
        }
    }
    
    /**
     * @param  string  $table
     *
     * @return int|bool|array
     * @throws JsonException
     */
    public function get(string $table): int|bool|array
    {
        
        try {
            $query = $this->connect()->query("SELECT * FROM $table");
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $throwable) {
            return failed((array)$throwable->getMessage(),
                $throwable->getCode(), $throwable->getTrace());
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
            $query = $this->connect()->prepare("UPDATE $table SET $fcolumns WHERE $wcolumns ");
            $query->execute($data);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed((array)$throwable->getMessage(),
                $throwable->getCode(), $throwable->getTrace());
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
        $placeholders = array_map(static fn($items) => " :$items ", array_keys($data));
        $values = implode(',', $placeholders);
        try {
            $query = $this->connect()->prepare("INSERT INTO $table ($fields) VALUES ($values)");
            $query->execute($data);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed((array)$throwable->getMessage(),
                $throwable->getCode(), $throwable->getTrace());
        }
    }
    
    /**
     * @param  string  $table
     * @param  array  $data
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function insertMulti(
        string $table,
        array $data
    ): bool|int|PDOStatement {
        
        $fields = implode(' , ', array_keys($data));
        $placeholders = array_map(static fn($items) => " :$items ", array_keys($data));
        $values = implode(',', $placeholders);
        try {
            $query = $this->connect()->prepare("INSERT INTO $table ($fields) VALUES ($values)");
            $this->connect()->beginTransaction();
            foreach ($data as $row) {
                $query->execute($row);
            }
            $this->connect()->commit();
            
            return $query;
        } catch (Throwable $throwable) {
            return failed((array)$throwable->getMessage(),
                $throwable->getCode(), $throwable->getTrace());
        }
    }
    
    /**
     * @param  string  $table
     * @param  array  $where
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function delete(string $table, array $where): bool|int|PDOStatement
    {
        
        $columns = array_keys($where);
        $condition = $this->where($columns);
        try {
            $query = $this->connect()->prepare("DELETE FROM $table WHERE $condition");
            $query->execute($where);
            $query->fetch(PDO::FETCH_ASSOC);
            
            return $query;
        } catch (Throwable $throwable) {
            return failed((array)$throwable->getMessage(),
                $throwable->getCode(), $throwable->getTrace());
        }
    }
    
}