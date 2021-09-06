<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
/*-----------------------------------------------------------------------------*/

class LoginController extends Controller
{

    public function __construct(){

        if(LoginHandler::checkLogin()){
            redirect()->route('home')->send();
        }

        /*check if it's a new access*/
        if(isset($_COOKIE['lastAccess'])){
            $tomorrow = strtotime('tomorrow');
            if($_COOKIE['lastAccess'] > $tomorrow){
                HomeHandler::sendAccessToDb();
                //echo 'existe mas esta expirado ent conta o acesso';
            }
        }else{
            setcookie('lastAccess', time(), time()+(86400 * 30));
            HomeHandler::sendAccessToDb();
            //echo 'nao tem cookie ent conta o acesso';
        }
        /***/
    }
    
    public function initial(){
        $data = LoginHandler::infoPageInitial();
        return view('initial',['data' => $data]);
    }

    public function login(Request $request){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        return view('login',[
            'flash' => $flash
        ]);
    }

    public function loginAction(Request $request){
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $keepConnected = filter_input(INPUT_POST, 'keepConnected');

        if($email && $password){
            
            $token = LoginHandler::verifyLogin($email, $password);

            if($token){
                $_SESSION['token'] = $token;

                if($keepConnected){
                    $expiration = time() + (86400*30);
                    setcookie('token', $token, $expiration);
                }

                return redirect()->route('home');

            }else{
                $_SESSION['flash'] = 'Email e/ou senha estão incorretos.';
            }

        }else{
            $_SESSION['flash'] = 'Não envie campos vazios.';
        }

        return redirect()->route('login');
    }

    public function register(Request $request){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        return view('register',[
            'flash' => $flash
        ]);
    }

    public function registerAction(Request $request){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($name && $email && $password && $confirmPassword){

            if($password === $confirmPassword){
                if(!LoginHandler::emailExists($email)){
                    $token = LoginHandler::addUser($name, $email, $password);
                    $_SESSION['token'] = $token;
                    return redirect()->route('home');
                }else{
                    $_SESSION['flash'] =  'Este email já esta registrado.';
                }
            }else{
                $_SESSION['flash'] = 'As senhas não podem ser diferentes.';
            }

        }else{
            $_SESSION['flash'] = 'Não deixe campos vazios.';
        }

        return redirect()->route('register');
    }
}
