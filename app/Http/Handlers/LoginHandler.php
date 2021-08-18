<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
/*-----------------------------------------------------------------------------*/

class LoginHandler{
    
    public static function infoPageInitial(){
        $data = Initial::first();
        return $data;
    }
    
}
