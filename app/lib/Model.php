<?php

namespace app\lib;

use JsonException;
use PDO;
use PDOStatement;

class Model extends Database
{
    /**
     * @throws JsonException
     */
    public function query(string $sql, array $data = null): bool|int|PDOStatement
    {
        $query = $this->connect()->prepare($sql);
        try {
            if (isset($data)) {
                $data = array_values($data);
                $query->execute($data);
            }else{
                $query->execute();
            }
            $query->setFetchMode(PDO::FETCH_OBJ);
            return $query;
        } catch (\Throwable $throwable) {
            return failed(
                $throwable->getMessage(),
                $throwable->getCode(),
                $throwable->getTrace(),
            );
        }
    }
}