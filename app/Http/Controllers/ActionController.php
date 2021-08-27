<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
use App\Http\Handlers\ActionHandler;
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

            ActionHandler::sendNewComment($message, $textid, $this->loggedUser);
            $_SESSION['flash'] = 'Comentário adicionado com sucesso.';

        }
        return back();
    }

    public function deleteComment(Request $request){
        $commentId = $request->id;

        if($commentId){
            ActionHandler::deleteComment($commentId);
            $_SESSION['flash'] = 'Comentário apagado com sucesso.';
        }
        return back();
    }

    public function sendNewSubComment(){
        $commentId = filter_input(INPUT_POST, 'commentid');
        $subComment = filter_input(INPUT_POST, 'newSubComment');
        $textId = filter_input(INPUT_POST, 'textid');
        $userToNot = filter_input(INPUT_POST, 'userToNot');

        if($commentId && $subComment && $textId){
            ActionHandler::sendNewSubComment($commentId, $subComment, $textId, $this->loggedUser);
            $_SESSION['flash'] = 'Comentário respondido com sucesso.';

            ActionHandler::sendCommentNotification($this->loggedUser, $userToNot, $commentId, $textId);

        }
        return back();
    }

    public function deleteSubComment(Request $request){
        $subCommentId = $request->id;

        if($subCommentId){
            ActionHandler::deleteSubComment($subCommentId);
            $_SESSION['flash'] = 'Resposta apagada com sucesso.';
        }
        return back();
    }

    public function follow(Request $request){
        ActionHandler::changeRelation($request->id, $this->loggedUser->id);

        ActionHandler::sendFollowNotification($this->loggedUser, $request->id);

        return back();
    }

    public function finishStudy(Request $request){
        $alreadyStudied = ActionHandler::getTextStudied($request->textid, $this->loggedUser->id);

        if($alreadyStudied){
            ActionHandler::removeTextStudied($request->textid, $this->loggedUser->id);
            return back();
        }else{
            ActionHandler::addTextStudied($request->textid, $this->loggedUser->id);
            redirect()->route('mytexts')->send();
        }
        exit;
    }

    public function saveText(Request $request){
        $alreadySaved = ActionHandler::getTextSaved($request->textid, $this->loggedUser->id);

        if($alreadySaved){
            ActionHandler::removeTextSaved($request->textid, $this->loggedUser->id);
        }else{
            ActionHandler::addTextSaved($request->textid, $this->loggedUser->id);
        }
        return back();
        exit;
    }

    public function updateProfile(){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $themeMode = filter_input(INPUT_POST, 'themeMode', FILTER_SANITIZE_SPECIAL_CHARS);
        $englishLevel = filter_input(INPUT_POST, 'englishLevel', FILTER_SANITIZE_SPECIAL_CHARS);
        $profilePictureChanged = false;
        $allowed = ['image/jpeg', 'image/jpg', 'image/png'];
        $namePhoto = '';

        if($name && $email && $themeMode){

            if(!empty($_FILES['photo']['name'])){
                $profilePictureChanged = true;
            }

            if($profilePictureChanged){
                if($_FILES['photo']['size'] > 2000000){
                    $_SESSION['error'] = 'A foto de perfil enviada é muito grande. (maximo 2MB)';
                    return back();
                    exit;
                }
        
                //if type is not allowed
                if(!in_array($_FILES['photo']['type'], $allowed)){
                    $_SESSION['error'] = 'Envie somente fotos jpeg, jpg ou png';
                    return back();
                    exit;
                } 

                //if that's ok
                $namePhoto = md5(time().rand(0,9999)).'.jpg';
                move_uploaded_file($_FILES['photo']['tmp_name'], 'media/avatars/'.$namePhoto);
            }


            if($this->loggedUser->name == $name && $this->loggedUser->email == $email && !$profilePictureChanged && $this->loggedUser->theme == $themeMode && $this->loggedUser->level == $englishLevel){
                $_SESSION['error'] = 'Você precisa alterar alguma coisa para poder salvar.';
                return back();
                exit;
            }


            ActionHandler::updateProfile($name, $email, $themeMode, $englishLevel,$profilePictureChanged, $namePhoto, $this->loggedUser->id);

            $_SESSION['success'] = 'Seu perfil foi atualizado com sucesso.';
            return back();
            exit;
        }else{
            $_SESSION['error'] = "Os campos 'nome', 'email' e 'thema' são obrigatorios!";
            return back();
            exit;
        }
    }

}
