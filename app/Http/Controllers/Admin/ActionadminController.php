<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\admin\ActionAdminHandler;
/*-----------------------------------------------------------------------------*/

class ActionadminController extends Controller{
    public function mainControls(Request $request){
        $btn = $request->btn;
        $action = $request->action;

        if($btn != 'system' && $btn != 'reports' && $btn != 'comments' && $btn != 'support'){
            return false;
        }
        if($action != 1 && $action != 0){
            return false;
        }

        ActionadminHandler::changeSystemInfo($btn, $action);
    }

}
