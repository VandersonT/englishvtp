<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
use App\Models\Daily_access;
use App\Models\Studied_text;
use App\Models\Text;
/*-----------------------------------------------------------------------------*/

class LoginHandler{
    
    public static function infoPageInitial(){
        $data = Initial::first();
        return $data;
    }

    public static function getTotalTexts(){
        $totalText = Text::count();

        if($totalText >= 5000){return '+5k';}

        if($totalText >= 2000){return '+2k';}
        
        if($totalText >= 999){return '+999';}

        if($totalText >= 500){return '+500';}

        if($totalText >= 100){return '+100';}

        return $totalText;
    }

    public static function getTotalAccounts(){
        $totalAccounts = User::count();

        if($totalAccounts >= 5000){return '+5k';}

        if($totalAccounts >= 2000){return '+2k';}
        
        if($totalAccounts >= 999){return '+999';}

        if($totalAccounts >= 500){return '+500';}

        if($totalAccounts >= 100){return '+100';}

        return $totalAccounts;
    }

    public static function getTotalStudiedTexts(){
        $totalStudiedText = Studied_text::count();

        if($totalStudiedText >= 5000){return '+5k';}

        if($totalStudiedText >= 2000){return '+2k';}
        
        if($totalStudiedText >= 999){return '+999';}

        if($totalStudiedText >= 500){return '+500';}

        if($totalStudiedText >= 100){return '+100';}

        return $totalStudiedText;
    }

    public static function checkLogin(){
       
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];

            $data = User::where('token', $token)->first();

            if($data){
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->name = $data['user_name'];
                $loggedUser->email = $data['email'];
                $loggedUser->password = $data['password'];
                $loggedUser->access = $data['access'];
                $loggedUser->token = $data['token'];
                $loggedUser->tokenAdmin = $data['token_admin'];
                $loggedUser->photo = $data['photo'];
                $loggedUser->theme = $data['theme'];
                $loggedUser->level = $data['level'];
                $loggedUser->points = $data['points'];
                return $loggedUser;
            }
            return false;
        }

        if(isset($_COOKIE['token'])){
            $token = $_COOKIE['token'];

            $data = User::where('token', $token)->first();

            if($data){
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->name = $data['user_name'];
                $loggedUser->email = $data['email'];
                $loggedUser->password = $data['password'];
                $loggedUser->access = $data['access'];
                $loggedUser->token = $data['token'];
                $loggedUser->tokenAdmin = $data['token_admin'];
                $loggedUser->photo = $data['photo'];
                $loggedUser->theme = $data['theme'];
                $loggedUser->level = $data['level'];
                $loggedUser->points = $data['points'];
                return $loggedUser;
            }
        }

        return false;
    }

    public static function verifyLogin($email, $password){

        $user = User::where('email', $email)->first();

        if($user){
            if(password_verify($password, $user['password'])){
                $token = md5(time().rand(0,9999).rand(0,9999));

                $updateUser = User::find($user->id);
                    $updateUser->token = $token;
                $updateUser->save();

                return $token;
            }
        }
        return false;
    }

    public static function emailExists($email){
        $user = User::where('email', $email)->first();
        return $user ? true : false;
    }

    public static function addUser($name, $email, $password){
        $token = md5(time().rand(0,9999).rand(0,9999));

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $newUser = new User;
            $newUser->user_name = $name;
            $newUser->email = $email;
            $newUser->password = $hash;
            $newUser->access = 1;
            $newUser->token = $token;
            $newUser->photo = 'no-picture2.png';
            $newUser->theme = 'light';
        $newUser->save();

        return $token;
    }

    public static function sendAccessToDb(){
        $newAccess = new Daily_access;
            $newAccess->access = date('d/m/Y', time());
        $newAccess->save();
    }
    
}
