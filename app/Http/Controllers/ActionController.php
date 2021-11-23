<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
use App\Http\Handlers\HomeHandler;
use App\Http\Handlers\ActionHandler;
/*-----------------------------------------------------------------------------*/

class ActionController extends Controller
{
    private $loggedUser;

    public function __construct(){
        date_default_timezone_set('America/Sao_Paulo');
        $this->loggedUser = LoginHandler::checkLogin();

        if(!$this->loggedUser){
            redirect()->route('initial')->send();
        }

        HomeHandler::updateLastAction($this->loggedUser->id);
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function sendNewComment(){

        $isUserExiled = ActionHandler::checkIfIsUserExiled($this->loggedUser->id);

        if($isUserExiled){
            $end = ($isUserExiled['time'] == 'eterno') ? 'Nesta conta o exilio foi determinado como permanente.' : 'O fim do exilio será: '.date('d/m/Y H:i', $isUserExiled['time']);
            $_SESSION['exiled'] = '<b>A sua conta foi exilada! Sendo assim, você está impedido de comentar e reportar qualquer comentário, o motivo é: <br/><br/>"'.$isUserExiled['reason'].'"<br/><br/>º'.$end.'</b>';
            return back();
            exit;
        }

        $message = filter_input(INPUT_POST, 'newcomment');
        $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $isCommentActive = HomeHandler::getSystemStatus('comments');

        if(!$isCommentActive){
           $_SESSION['error'] = 'Não é possivel escrever um novo comentário no momento.';
           return back();
           exit;
        }

        if($message && $textid){

            ActionHandler::sendNewComment($message, $textid, $this->loggedUser);
            $_SESSION['success'] = 'Comentário adicionado com sucesso.';

        }
        return back();
        exit;
    }

    public function deleteComment(Request $request){
        $commentId = $request->id;

        if($commentId){
            ActionHandler::deleteComment($commentId);
            $_SESSION['success'] = 'Comentário apagado com sucesso.';
        }
        return back();
    }

    public function sendNewSubComment(){
        
        $isUserExiled = ActionHandler::checkIfIsUserExiled($this->loggedUser->id);

        if($isUserExiled){
            $end = ($isUserExiled['time'] == 'eterno') ? 'Nesta conta o exilio foi determinado como permanente.' : 'O fim do exilio será: '.date('d/m/Y H:i', $isUserExiled['time']);
            $_SESSION['exiled'] = '<b>A sua conta foi exilada! Sendo assim, você está impedido de comentar e reportar qualquer comentário, o motivo é: <br/><br/>"'.$isUserExiled['reason'].'"<br/><br/>º'.$end.'</b>';
            return back();
            exit;
        }

        $isCommentActive = HomeHandler::getSystemStatus('comments');

        if(!$isCommentActive){
           $_SESSION['error'] = 'Não é possivel escrever um novo comentário no momento.';
           return back();
           exit;
        }

        $commentId = filter_input(INPUT_POST, 'commentid');
        $subComment = filter_input(INPUT_POST, 'newSubComment');
        $textId = filter_input(INPUT_POST, 'textid');
        $userToNot = filter_input(INPUT_POST, 'userToNot');

        if($commentId && $subComment && $textId){
            ActionHandler::sendNewSubComment($commentId, $subComment, $textId, $this->loggedUser);
            $_SESSION['success'] = 'Comentário respondido com sucesso.';

            ActionHandler::sendCommentNotification($this->loggedUser, $userToNot, $commentId, $textId);

        }
        return back();
    }

    public function deleteSubComment(Request $request){
        $subCommentId = $request->id;

        if($subCommentId){
            ActionHandler::deleteSubComment($subCommentId);
            $_SESSION['success'] = 'Resposta apagada com sucesso.';
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

        $textPoints = ActionHandler::getTextPoints($request->textid);

        if($alreadyStudied){
            ActionHandler::removeTextStudied($request->textid, $this->loggedUser->id);

            ActionHandler::downLevelUser($this->loggedUser->id, $textPoints);

            return back();
        }else{
            ActionHandler::addTextStudied($request->textid, $this->loggedUser->id);

            ActionHandler::upLevelUser($this->loggedUser->id, $textPoints);

            redirect()->route('mytexts')->send();
        }
        exit;
    }

    public function saveText(Request $request){
        $alreadySaved = ActionHandler::getTextSaved($request->textid, $this->loggedUser->id);

        if($alreadySaved){
            ActionHandler::removeTextSaved($request->textid, $this->loggedUser->id);
        }else{

            $reachedTheLimit = ActionHandler::checkIfReachedTheLimit($this->loggedUser->id);

            if($reachedTheLimit >= 10){
                $_SESSION['error'] = 'Você só pode salvar 10 textos, remova algum antes de salvar novamente.';
            }else{
                ActionHandler::addTextSaved($request->textid, $this->loggedUser->id);
            }

        }
        return back();
        exit;
    }

    public function updateProfile(){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        //$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $this->loggedUser->email;
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

                //apaga a antiga se ele teve um antiga ne
                if($this->loggedUser->photo != 'no-picture2.png'){
                    unlink('media/avatars/'.$this->loggedUser->photo);
                }
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

    public function newSupport(){
        
        $isUserExiled = ActionHandler::checkIfIsUserExiled($this->loggedUser->id);

        if($isUserExiled){
            $end = ($isUserExiled['time'] == 'eterno') ? 'Nesta conta o exilio foi determinado como permanente.' : 'O fim do exilio será: '.date('d/m/Y H:i', $isUserExiled['time']);
            $_SESSION['exiled'] = '<b>A sua conta foi exilada! Sendo assim, você está impedido de ultilizar o suporte, o motivo é: <br/><br/>"'.$isUserExiled['reason'].'"<br/><br/>º'.$end.'</b>';
            return back();
            exit;
        }

        $isSupportActive = HomeHandler::getSystemStatus('support');

        if(!$isSupportActive){
           $_SESSION['error'] = 'Não é possivel escrever um novo comentário no momento.';
           return back();
           exit;
        }

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

        if($title && $content){

            ActionHandler::sendNewSupport($this->loggedUser->id, $title, $content);
            $_SESSION['success'] = "Seu chamado foi aberto com sucesso, logo te retornaremos.";
        }

        redirect()->route('support')->send();
        exit;
    }

    public function replySupport(Request $request){
        
        $isUserExiled = ActionHandler::checkIfIsUserExiled($this->loggedUser->id);

        if($isUserExiled){
            $end = ($isUserExiled['time'] == 'eterno') ? 'Nesta conta o exilio foi determinado como permanente.' : 'O fim do exilio será: '.date('d/m/Y H:i', $isUserExiled['time']);
            $_SESSION['exiled'] = '<b>A sua conta foi exilada! Sendo assim, você está impedido de ultilizar o suporte, o motivo é: <br/><br/>"'.$isUserExiled['reason'].'"<br/><br/>º'.$end.'</b>';
            return back();
            exit;
        }
        
        $isSupportActive = HomeHandler::getSystemStatus('support');

        if(!$isSupportActive){
           $_SESSION['error'] = 'Não é possivel escrever um novo comentário no momento.';
           return back();
           exit;
        }
        
        $reply = filter_input(INPUT_POST, 'reply', FILTER_SANITIZE_SPECIAL_CHARS);
        $idSupport = $request->id;

        if($reply && $idSupport){
            ActionHandler::sendNewSupportReply($reply, $this->loggedUser->id, $idSupport);
            $_SESSION['success'] = "Resposta enviada com sucesso.";
        }
        return back();
        exit;
    }

    public function reportComment(Request $request){

        $isUserExiled = ActionHandler::checkIfIsUserExiled($this->loggedUser->id);

        if($isUserExiled){
            $end = ($isUserExiled['time'] == 'eterno') ? 'Nesta conta o exilio foi determinado como permanente.' : 'O fim do exilio será: '.date('d/m/Y H:i', $isUserExiled['time']);
            $_SESSION['exiled'] = '<b>A sua conta foi exilada! Sendo assim, você está impedido de comentar e reportar qualquer comentário, o motivo é: <br/><br/>"'.$isUserExiled['reason'].'"<br/><br/>º'.$end.'</b>';
            return back();
            exit;
        }

        $isReportActive = HomeHandler::getSystemStatus('reports');


        if($isReportActive){
            $done = ActionHandler::sendReportComment($this->loggedUser->id, $request->type, $request->id);

            if($done){
                $_SESSION['success'] = "Você denunciou este comentário aos administradores.";
            }else{
                $_SESSION['error'] = "Você já reportou esse comentário antes.";
            }
        }else{
            $_SESSION['error'] = "Os reportes estão desabilitados no momento.";
        }

        return back();
        exit;
    }

}
