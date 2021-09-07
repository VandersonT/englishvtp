<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
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
    
}
