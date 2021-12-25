<?php

namespace app\Http\Controllers;

use app\core\lib\Controller;
use app\Models\UserModel;
use JsonException;
use PDOStatement;

class AppController extends Controller
{
    
    /**
     * @param  int  $id
     *
     * @return bool|PDOStatement
     * @throws JsonException
     */
    public static function index(int $id): bool|PDOStatement
    {
        
        $user = new UserModel();
        
        return ok($user->getUsersWhere(['id' => $id]));
    }
    
}