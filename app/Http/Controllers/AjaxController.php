<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
use App\Http\Handlers\HomeHandler;
use App\Http\Handlers\AjaxHandler;
/*-----------------------------------------------------------------------------*/

class AjaxController extends Controller{
    private $loggedUser;

    public function __construct(){
        $this->loggedUser = LoginHandler::checkLogin();

        if(!$this->loggedUser){
            header("Content-Type: application/json");
            echo json_encode(['error' => 'Usuário não logado']);
            exit;
        }
    }

    public function like(Request $request){
        $idComment = $request->id;
        $rate = $request->rate;
        $commentType = $request->type;

        $isRated = AjaxHandler::isRated($idComment, $rate, $commentType, $this->loggedUser->id);
    
        $userToNotification = AjaxHandler::getUserToNotification($idComment, $commentType);

        if($isRated){

            if($isRated == $rate){
                AjaxHandler::deleteRated($idComment, $commentType, $this->loggedUser->id);
            }else{
                AjaxHandler::updateRated($idComment, $commentType, $this->loggedUser->id, $rate);
            }

        }else{
            AjaxHandler::addRated($idComment, $commentType, $this->loggedUser->id, $rate);
        }
        
        if($userToNotification != $this->loggedUser->id && $isRated != $rate){
            AjaxHandler::sendRatedNotification($this->loggedUser, $idComment, $rate, $userToNotification);
        }

    }

}
