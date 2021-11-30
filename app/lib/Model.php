<?php

namespace app\lib;

use PDO;
use PDOStatement, JsonException, Throwable;

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
            if (isset($data)) {
                $data = array_values($data);
                $query->execute($data);
            } else {
                $query->execute();
            }
            $query->setFetchMode(PDO::FETCH_OBJ);
            return $query;
        } catch (Throwable $throwable) {
            return failed(
                $throwable->getMessage(),
                $throwable->getCode(),
                $throwable->getTrace(),
            );
        }
    }

    /**
     * @throws JsonException
     */
    public function select(string $table, array $data): bool|PDOStatement
    {
        $columns = array_keys($data);
        $condition = $this->condition($columns);
        try {
            $query = $this->connect()->prepare(
                "SELECT * FROM $table WHERE $condition"
            );
            $query->execute($data);
            $query->setFetchMode(PDO::FETCH_OBJ);
            return $query;
        } catch (Throwable $throwable) {
            return failed(
                $throwable->getMessage(),
                $throwable->getCode(),
                $throwable->getTrace(),
            );
        }
    }

    protected function condition($data)
    {
        $keys = array_map(static fn($items) => "$items = :$items", $data);
        (count($data) > 1) ? $condition = implode(' AND ', $keys)
            : $condition = implode('', $keys);
        return $condition;
    }
}