<?php

namespace app\core\lib;

use app\Models\UserModel;
use JsonException;

/**
 * @property array $fields
 */
class Auth
{
    
    /**
     * @param  UserModel  $user
     * @param  array  $credentials
     *
     * @return int
     * @throws JsonException
     */
    public function check(UserModel $user, array $credentials): int
    {
        
        if ($user->getUsersWhere($credentials)) {
            $this->createFieldsForSession($user->getUsersWhere($credentials));
            
            return true;
        }
        
        return false;
    }
    
    /**
     * @param  object  $user
     */
    protected function createFieldsForSession(
        object $user
    ): void {
        
        foreach ($user as $item) {
            array_map(static fn($keys) => $_SESSION[$keys] = $item[$keys],
                array_keys($item));
        }
    }
    
}