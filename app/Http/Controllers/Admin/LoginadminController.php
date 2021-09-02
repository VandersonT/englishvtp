<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\admin\LoginAdminHandler;
/*-----------------------------------------------------------------------------*/

class LoginadminController extends Controller
{

    public function __construct(){
        if(LoginAdminHandler::checkLoginAdmin()){
            redirect()->route('painel')->send();
        }
    }

    public function login(Request $request){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        return view('admin/loginAdmin',[
           'flash' => $flash
        ]);
    }

    public function loginAction(){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $keepConnected = filter_input(INPUT_POST, 'keepConnected');

        if($email && $password){

            $tokenAdmin = LoginAdminHandler::verifyLogin($email, $password);

            if($tokenAdmin){

                $isAnAdm = LoginAdminHandler::checkIfItsAnAdmin($email);
                if($isAnAdm){
                        $_SESSION['tokenAdmin'] = $tokenAdmin;
                    
                    if($keepConnected){
                        $expiration = time() + (86400*30);
                        setcookie('tokenAdmin', $tokenAdmin, $expiration);
                    }
                    redirect()->route('painel')->send();
                }else{
                    $_SESSION['flash'] = 'Esta conta não faz parte da staff.';
                }
            }else{
                $_SESSION['flash'] = 'Email e/ou senha estão errados.';
            }

        }else{
            $_SESSION['flash'] = 'Não envie campos vazios';
        } 
        return redirect()->route('loginAdmin');
        exit;
    }
}
