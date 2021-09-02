<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\admin\LoginAdminHandler;
/*-----------------------------------------------------------------------------*/

class AdminController extends Controller
{
    private $loggedAdmin;

    public function __construct(){
        $this->loggedAdmin = LoginAdminHandler::checkLoginAdmin();

        if(!$this->loggedAdmin){
            redirect()->route('loginAdmin')->send();
        }

        if($this->loggedAdmin->access < 2){
            $_SESSION['tokenAdmin'] = '';
            if(isset($_COOKIE['tokenAdmin'])){
                setcookie('tokenAdmin', '', time()-3600);
            }
            redirect()->route('loginAdmin')->send();
        }

    }

    public function index(){
        return view('admin/home',[
            'user' => $this->loggedAdmin,
            'selected' => 'dashboard'
        ]);
    }

    public function pages(){
        return view('admin/pages',[
            'user' => $this->loggedAdmin,
            'selected' => 'pages'
        ]);
    }

    public function logout(){
        $_SESSION['tokenAdmin'] = '';

        if(isset($_COOKIE['tokenAdmin'])){
            setcookie('tokenAdmin', '', time()-3600);
        }

        redirect()->route('loginAdmin')->send();
    }
}
