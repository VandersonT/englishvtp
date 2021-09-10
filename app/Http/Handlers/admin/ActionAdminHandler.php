<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\System;
/*-----------------------------------------------------------------------------*/

class ActionAdminHandler{

    public static function changeSystemInfo($btn, $action){
        switch($btn){
            case 'system':
                $system = System::
                    where('id', 1)
                ->update(['system' => $action]);
                echo 'trocado sistema';
                break;
            case 'reports':
                $system = System::
                    where('id', 1)
                ->update(['reports' => $action]);
                echo 'trocado reportes';
                break;
            case 'comments':
                $system = System::
                    where('id', 1)
                ->update(['comments' => $action]);
                echo 'trocado comments';
                break;
            case 'support':
                $system = System::
                    where('id', 1)
                ->update(['support' => $action]);
                echo 'trocado suports';
                break;
        }
        echo 'fechou';
    }

    public static function isAdmOrOwner($userSearch){
        $user = User::where('id', $userSearch)->first();

        return $user['access'];
    }
    
    public static function changeUserAccess($userToChange, $newAccess){
       
        $data = User::where('id', $userToChange)->first();

        $position = '';
        if($newAccess == 1){
            $position = 'usuário';
        }
        if($newAccess == 2){
            $position = 'ajudante'; 
        }
        if($newAccess == 3){
            $position = 'moderador';
        }
        if($newAccess == 4){
            $position = 'administrador';
        }
        if($newAccess == 5){
            $position = 'dono';
        }

        $user = User::
            where('id', $userToChange)
        ->update(['access' => $newAccess]);

        if($newAccess < $data['access']){
            $flash = 'Você rebaixou o usuário '.$data['user_name'].' para o cargo de '.$position.' do sistema.';
            return $flash;
        }

        $flash = 'Você promoveu o usuário '.$data['user_name'].' para o cargo de '.$position.' do sistema.';
        return $flash;
    }

}
