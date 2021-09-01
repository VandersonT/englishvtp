<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
/*-----------------------------------------------------------------------------*/

class LoginAdminHandler{

    public static function checkLoginAdmin(){
       
        if(!empty($_SESSION['tokenAdmin'])){
            $tokenAdmin = $_SESSION['tokenAdmin'];

            $data = User::where('token_admin', $tokenAdmin)->first();

            if($data){
                $loggedAdmin = new User();
                $loggedAdmin->id = $data['id'];
                $loggedAdmin->name = $data['user_name'];
                $loggedAdmin->email = $data['email'];
                $loggedAdmin->password = $data['password'];
                $loggedAdmin->access = $data['access'];
                $loggedAdmin->token = $data['token'];
                $loggedAdmin->tokenAdmin = $data['token_admin'];
                $loggedAdmin->photo = $data['photo'];
                $loggedAdmin->theme = $data['theme'];
                $loggedAdmin->level = $data['level'];
                $loggedAdmin->points = $data['points'];
                return $loggedAdmin;
            }
        }

        if(isset($_COOKIE['tokenAdmin'])){
            $tokenAdmin = $_COOKIE['tokenAdmin'];

            $data = User::where('token_admin', $tokenAdmin)->first();

            if($data){
                $loggedAdmin = new User();
                $loggedAdmin->id = $data['id'];
                $loggedAdmin->name = $data['user_name'];
                $loggedAdmin->email = $data['email'];
                $loggedAdmin->password = $data['password'];
                $loggedAdmin->access = $data['access'];
                $loggedAdmin->token = $data['token'];
                $loggedAdmin->tokenAdmin = $data['token_admin'];
                $loggedAdmin->photo = $data['photo'];
                $loggedAdmin->theme = $data['theme'];
                $loggedAdmin->level = $data['level'];
                $loggedAdmin->points = $data['points'];
                return $loggedAdmin;
            }
        }

        return false;
    }
    
}
