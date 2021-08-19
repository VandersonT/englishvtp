<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
/*-----------------------------------------------------------------------------*/

class LoginHandler{
    
    public static function infoPageInitial(){
        $data = Initial::first();
        return $data;
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
                $loggedUser->status = $data['status'];
                $loggedUser->token = $data['token'];
                $loggedUser->tokenAdmin = $data['token_admin'];
                $loggedUser->photo = $data['photo'];
                $loggedUser->theme = $data['theme'];
                return $loggedUser;
            }
            return false;
        }

        /*
        verifica aqui se tem um cookie com a seção, se tiver trate como se fosse uma section.
        */

        return false;
    }

    public static function verifyLogin($email, $password){

        $user = User::where('email', $email)->first();

        if($user){
            if(password_verify($password, $user['password'])){
                $token = md5(time().rand(0,9999).rand(0,9999));

                $updateUser = User::find($email);
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
            $newUser->status = 1;
            $newUser->token = $token;
            $newUser->photo = 'no-picture.png';
            $newUser->theme = 'light';
        $newUser->save();

        return $token;
    }
    
}
