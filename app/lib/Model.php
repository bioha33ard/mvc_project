<?php

namespace app\lib;

use JsonException;
use PDO;
use PDOStatement;
use Throwable;

class Model extends Database
{
    
    /**
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
    
    public function update(string $table, array $fields, array $where)
    {
        
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
    
    protected function buildFieldsString(array $data): string
    {
        
        return implode(' , ', $this->buildFields($data));
    }
    
    protected function where(array $data): string
    {
        
        $keys = $this->buildFields($data);
        
        return (count($data) > 1) ? implode(' AND ', $keys)
            : implode('', $keys);
    }
    
    protected function buildFields(array $data): array
    {
        
        return array_map(static fn($items) => "$items = :$items", $data);
    }
    
}