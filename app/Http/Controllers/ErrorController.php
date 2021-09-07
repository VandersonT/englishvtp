<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\HomeHandler;
/*-----------------------------------------------------------------------------*/

class ErrorController extends Controller{
    
    public function error404(){
        return view('404');
    }

    public function maintenance(){

        $isSystemActive = HomeHandler::getSystemStatus();

        if($isSystemActive){
            redirect()->route('home')->send();
        }

        return view('maintenance');
    }

    public function endSection(){
        $_SESSION['token'] = '';

        if(isset($_COOKIE['token'])){
            setcookie('token', '', time()-3600);
        }

        redirect()->route('login')->send();
    }

}
