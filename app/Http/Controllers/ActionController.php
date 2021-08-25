<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
use App\Http\Handlers\HomeHandler;
/*-----------------------------------------------------------------------------*/

class ActionController extends Controller
{
    private $loggedUser;

    public function __construct(){
        date_default_timezone_set('America/Sao_Paulo');
        $this->loggedUser = LoginHandler::checkLogin();

        if(!$this->loggedUser){
            redirect()->route('login')->send();
        }
    }

    public function sendNewComment(){
        $message = filter_input(INPUT_POST, 'newcomment', FILTER_SANITIZE_SPECIAL_CHARS);
        $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($message && $textid){

            HomeHandler::sendNewComment($message, $textid, $this->loggedUser);
            $_SESSION['flash'] = 'Comentário adicionado com sucesso.';

        }
        return redirect()->route('text', $textid)->send();
    }

    public function deleteComment(Request $request){
        $commentId = $request->id;

        if($commentId){
            HomeHandler::deleteComment($commentId);
            $_SESSION['flash'] = 'Comentário apagado com sucesso.';
        }
        echo "<script>window.history.back()</script>";
    }

    public function sendNewSubComment(){
        $commentId = filter_input(INPUT_POST, 'comment');
        $subComment = filter_input(INPUT_POST, 'newSubComment');
        $textId = filter_input(INPUT_POST, 'text');
        
        if($commentId && $subComment && $textId){
            HomeHandler::sendNewSubComment($commentId, $subComment, $textId, $this->loggedUser);
            $_SESSION['flash'] = 'Comentário respondido com sucesso.';
        }
        return redirect()->route('text', $textId)->send();
    }

    public function deleteSubComment(Request $request){
        $subCommentId = $request->id;

        if($subCommentId){
            HomeHandler::deleteSubComment($subCommentId);
            $_SESSION['flash'] = 'Resposta apagada com sucesso.';
        }
        echo "<script>window.history.back()</script>";
    }

    public function follow(Request $request){
        HomeHandler::changeRelation($request->id, $this->loggedUser->id);
        echo "<script>window.history.back()</script>";
    }

}