<?php

namespace app\Models;

use app\core\lib\Model;
use JsonException;
use PDOStatement;

class UserModel extends Model
{
    
    protected string $table = 'users';
    
    public array $fillable
        = [
            'id',
            'first_name',
            'last_name',
            'email',
        ];
    
    /**
     * @return int|bool|array
     * @throws JsonException
     */
    public function getUsers(): int|bool|array
    {
        
        return $this->get($this->table);
    }
    
    
    /**
     * @param  array  $where
     *
     * @return bool|array|PDOStatement
     * @throws JsonException
     */
    public function getUsersWhere(array $where): bool|array|PDOStatement
    {
        
        return $this->select($this->table, $where);
    }
    
    /**
     * @param  array  $data
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function create(array $data): bool|int|PDOStatement
    {
        
        return $this->insert($this->table, $data);
    }
    
    /**
     * @param  array  $data
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function createMulti(array $data): bool|int|PDOStatement
    {
        
        return $this->insertMulti($this->table, $data);
    }
    
    /**
     * @param $fields
     * @param $where
     *
     * @return bool|int|PDOStatement
     * @throws JsonException
     */
    public function updateUser($fields, $where): bool|int|PDOStatement
    {
        
        return $this->update($this->table, $fields, $where);
    }
    
}