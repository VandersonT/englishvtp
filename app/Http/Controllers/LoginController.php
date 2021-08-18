<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
/*-----------------------------------------------------------------------------*/

class LoginController extends Controller
{
    
    public function initial(){
        
        $data = LoginHandler::infoPageInitial();

        return view('initial',['data' => $data]);
    }

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }
}
