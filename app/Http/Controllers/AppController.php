<?php

namespace app\Http\Controllers;

use app\core\lib\Auth;
use app\core\lib\Controller;
use app\Http\Requests\PostRequest;
use app\Http\Requests\RegisterRequest;
use app\Models\UserModel;
use JsonException;

class AppController extends Controller
{
    
    
    
    /**
     * @throws JsonException
     */
    public static function login()
    {
        
        $login_request = PostRequest::checkError($_POST);
        $auth = new Auth();
        if ($auth->check(new UserModel(), [
            'email'    => $login_request['email'],
            'password' => $login_request['password'],
        ])
        ) {
            print $_SESSION['id'];
        }
        
        return false;
    }
    
    public static function register()
    {
        
        $register_request = RegisterRequest::check($_POST);
    }
    
}