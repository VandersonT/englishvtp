<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\admin\ActionAdminHandler;
use App\Http\Handlers\admin\LoginAdminHandler;
/*-----------------------------------------------------------------------------*/

class ActionadminController extends Controller{

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
    
    public function changeAccess(Request $request){

        if($this->loggedAdmin->access < 4){
            ActionadminHandler::changeUserAccess($this->loggedAdmin->id, 1);
            $_SESSION['flash'] = '|Ant-Bug| Você acessou uma página não permitida ao seu cargo e foi rebaixado. Contate o dono para resolver isso.';
            return back();
            exit;
        }

        if($this->loggedAdmin->access < 5 && $request->newAccess >= $this->loggedAdmin->access){
            $_SESSION['error'] = 'Você só pode dar cargos que sejam menores que o seu.';
            return back();
            exit;
        }

        $userToChangePosition = ActionadminHandler::isAdmOrOwner($request->id);

        if($userToChangePosition >= 4 && $this->loggedAdmin->access < 5 ){
            $_SESSION['error'] = 'Somente os donos do sistema podem alterar o cargo de um administrador/dono.';
            return back();
            exit;
        }

        if($userToChangePosition == $request->newAccess){
            $_SESSION['error'] = 'Você deve alterar o cargo para poder salvar.';
            return back();
            exit;
        }

        $msgToFlash = ActionadminHandler::changeUserAccess($request->id, $request->newAccess);

        $_SESSION['success'] = $msgToFlash;
        return back();
        exit;

    }

    public function deleteBan(Request $request){
        if($this->loggedAdmin->access < 4){
            ActionadminHandler::changeUserAccess($this->loggedAdmin->id, 1);
            $_SESSION['flash'] = '|Ant-Bug| Você tentou realizar uma ação não permitida a força, por segurança você foi rebaixado, contate o dono para resolver isso.';
            return back();
            exit;
        }

        ActionadminHandler::unBanUser($request->id);

        $_SESSION['flash'] = 'Você desbaniu com sucesso o usuário de id '.$request->id;
        return back();
        exit;

    }

}
