<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\HomeHandler;
use App\Http\Handlers\LoginHandler;
/*-----------------------------------------------------------------------------*/

class ErrorController extends Controller{
    
    public function __construct(){
        /*Get LoggedUser*/
        $this->loggedUser = LoginHandler::checkLogin();

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function error404(){
        return view('404');
    }

    public function maintenance(){

        $isSystemActive = HomeHandler::getSystemStatus('system');

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

    public function banned(){
        
        if(!$this->loggedUser){
            redirect()->route('login')->send();
            exit;
        }

        $infoBan = HomeHandler::checkBan($this->loggedUser->id);

        if(!$infoBan){
            redirect()->route('home')->send();
            exit;
        }

        return view('ban',[
            'infoBan' => $infoBan
        ]);
    }

}
