<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\admin\ActionAdminHandler;
use App\Http\Handlers\HomeHandler;
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

        date_default_timezone_set('America/Sao_Paulo');
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

    public function sendNotification(){
        $user_to = filter_input(INPUT_POST, 'user_to');
        $color = filter_input(INPUT_POST, 'color');
        $title = filter_input(INPUT_POST, 'title');
        $content = filter_input(INPUT_POST, 'content');

        if($user_to >= 0 && $color && $title && $content){

            $error = ActionadminHandler::sendNotification($user_to,$color,$title,$content,$this->loggedAdmin->id);
            
            if(!$error){
                $_SESSION['success'] = 'A notificação foi enviada com sucesso! <br/>Você pode remove-la clicando no simbolo de confirações que se encontra no canto inferior direito da tela.';
            }else{  
                $_SESSION['error'] = $error;
            }

        }else{
            $_SESSION['error'] = 'Não envie campos vazios, todos os campos são necessarios.';
        }

        return back();
        exit;
    }
    
    public function deleteNotification(Request $request){
        ActionadminHandler::deleteNotification($request->id);
        $_SESSION['flash'] = 'A notificação foi apagada com sucesso, o usuário não poderá mais vizualizar ela.';
        return back();
        exit;
    }

    public function changeAccess(Request $request){

        if($this->loggedAdmin->access < 4){
            ActionadminHandler::changeUserAccess($this->loggedAdmin->id, 1);
            $_SESSION['flash'] = '|Ant-Bug| Você acessou uma página não permitida ao seu cargo e foi rebaixado. Contate o dono para resolver isso.';
            return back();
            exit;
        }

        if($request->id == $this->loggedAdmin->id){
            $_SESSION['error'] = "Você não pode alterar seu próprio cargo.";
            return back();
            exit; 
        }

        if($this->loggedAdmin->access < 5 && $request->newAccess >= $this->loggedAdmin->access){
            $_SESSION['error'] = 'Você só pode dar cargos que sejam menores que o seu.';
            return back();
            exit;
        }

        $userToChangePosition = ActionadminHandler::getUserAccess($request->id);

        if($userToChangePosition >= 4 && $this->loggedAdmin->access < 5 ){
            $_SESSION['error'] = 'Somente os donos do sistema pode alterar o cargo de um administrador/dono.';
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

    public function banAction(){
        $idToBan = filter_input(INPUT_POST, 'idToBan', FILTER_SANITIZE_SPECIAL_CHARS);
        $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_SPECIAL_CHARS);
        $formTime = filter_input(INPUT_POST, 'formTime', FILTER_SANITIZE_SPECIAL_CHARS);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS);

        if($idToBan && $reason && $formTime){

            if($idToBan == $this->loggedAdmin->id){
                $_SESSION['error'] = "Calma ae, você não pode banir você mesmo.";
                return back();
                exit; 
            }

            if(!$time && $formTime != 'Eterno'){
                $_SESSION['error'] = "Ocorreu um erro inesperado durante o banimento.";
                return back();
                exit; 
            }

            if($time < 0 && $formTime != 'Eterno'){
                $_SESSION['error'] = "Não use números negativos para definir o tempo do banimento.";
                return back();
                exit; 
            }

            $alreadyBan = HomeHandler::checkBan($idToBan);
            if($alreadyBan){
                $timeEnd = ($alreadyBan['time'] == 'eterno') ? 'O banimento foi definido como eterno' : 'O fim do banimento é '.date('d/m/Y H:i', $alreadyBan['time']);
                $_SESSION['error'] = "Este usuário já foi banido por ".$alreadyBan['user_name'].". <br/>".$timeEnd.". <br/>Se quiser atualizar basta desbanir o usuário e tornar a banir.";
                return back();
                exit;
            }

            $userToBanAccess = ActionadminHandler::getUserAccess($idToBan);
            if($userToBanAccess > 1){
                $_SESSION['error'] = "Este usuário pertence a staff, para bani-lo você deve retirar o cargo dele.";
                return back();
                exit;
            }

            $success = ActionadminHandler::banAction($idToBan, $reason,$formTime, $time, $this->loggedAdmin->id);

            if($success){
                $_SESSION['success'] = 'O usuário de id '.$idToBan.' foi banido com sucesso.';
            }else{
                $_SESSION['error'] = 'Desculpe, mas não encontramos o usuário informado.';
            }

        }else{
            $_SESSION['error'] = 'Desculpe, mas você deve informar todos os campos para que o ban seja valido.';
        }

        return back();
        exit;
    }

    public function exileAction(){
        $idToExile = filter_input(INPUT_POST, 'idToExile', FILTER_SANITIZE_SPECIAL_CHARS);
        $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_SPECIAL_CHARS);
        $formTime = filter_input(INPUT_POST, 'formTime', FILTER_SANITIZE_SPECIAL_CHARS);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS);

        if($idToExile && $reason && $formTime){

            if($idToExile == $this->loggedAdmin->id){
                $_SESSION['error'] = "Calma ae, você não pode exilar você mesmo.";
                return back();
                exit; 
            }

            if(!$time && $formTime != 'Eterno'){
                $_SESSION['error'] = "Ocorreu um erro inesperado durante o exilio.";
                return back();
                exit; 
            }

            if($time < 0 && $formTime != 'Eterno'){
                $_SESSION['error'] = "Não use números negativos para definir o tempo do exilio.";
                return back();
                exit; 
            }

            $alreadyExiled = HomeHandler::checkExile($idToExile);
            if($alreadyExiled){
                $timeEnd = ($alreadyExiled['time'] == 'eterno') ? 'O exilio foi definido como eterno' : 'O fim do exilio é '.date('d/m/Y H:i', $alreadyExiled['time']);
                $_SESSION['error'] = "Este usuário já foi exilado por ".$alreadyExiled['user_name'].". <br/>".$timeEnd.". <br/>Se quiser atualizar basta repatriar o usuário e tornar a banir.";
                return back();
                exit;
            }

            $userToBanAccess = ActionadminHandler::getUserAccess($idToExile);
            if($userToBanAccess > 1){
                $_SESSION['error'] = "Este usuário pertence a staff, para exila-lo você deve retirar o cargo dele.";
                return back();
                exit;
            }

            $success = ActionadminHandler::exileAction($idToExile, $reason,$formTime, $time, $this->loggedAdmin->id);

            if($success){
                $_SESSION['success'] = 'O usuário de id '.$idToExile.' foi exilado com sucesso.';
            }else{
                $_SESSION['error'] = 'Desculpe, mas não encontramos o usuário informado.';
            }

        }else{
            $_SESSION['error'] = 'Desculpe, mas você deve informar todos os campos para que o exilio seja valido.';
        }

        return back();
        exit;
    }

    public function deleteExile(Request $request){
        if($this->loggedAdmin->access < 4){
            ActionadminHandler::changeUserAccess($this->loggedAdmin->id, 1);
            $_SESSION['flash'] = '|Ant-Bug| Você tentou realizar uma ação não permitida a força, por segurança você foi rebaixado, contate o dono para resolver isso.';
            return back();
            exit;
        }

        ActionadminHandler::repatriateUser($request->id);

        $_SESSION['flash'] = 'Você repatriou com sucesso o usuário de id '.$request->id;
        return back();
        exit;
    }

    public function sendNewText(){

        if($this->loggedAdmin->access < 4){
            redirect()->route('painel')->send();
            exit;
        }

        $allowed = ['image/jpeg', 'image/jpg', 'image/png'];
        $allowedAudio = ['audio/mpeg', 'audio/mp3', 'audio/wav'];

        /*Audio verify*/
        if(empty($_FILES['audio']['name'])){
            $_SESSION['error'] = 'Você deve enviar um aúdio para o texto.';
            echo "<script>history.go(-1)</script>";
            exit;
        }
        if($_FILES['audio']['size'] > 10000000){
            $_SESSION['error'] = 'O aúdio enviado é muito grande. (maximo 5MB)';
            return back();
            exit;
        }
        if(!in_array($_FILES['audio']['type'], $allowedAudio)){
            $_SESSION['error'] = 'Envie somente aúdios mp3 ou wav';
            return back();
            exit;
        } 
        /***/

        /*Image verify*/
        if(empty($_FILES['image']['name'])){
            $_SESSION['error'] = 'Você deve enviar uma foto para o texto.';
            return back();
            exit;
        }

        if($_FILES['image']['size'] > 2000000){
            $_SESSION['error'] = 'A foto enviada é muito grande. (maximo 2MB)';
            return back();
            exit;
        }

        if(!in_array($_FILES['image']['type'], $allowed)){
            $_SESSION['error'] = 'Envie somente imagens jpeg, jpg ou png';
            return back();
            exit;
        } 
        /***/

        $englishLevel = filter_input(INPUT_POST, 'englishLevel');
        $points = filter_input(INPUT_POST, 'points');
        $englishType = filter_input(INPUT_POST, 'englishType');
        $englishTitle = filter_input(INPUT_POST, 'englishTitle');
        $englishContent = filter_input(INPUT_POST, 'englishContent');
        $portugueseTitle = filter_input(INPUT_POST, 'portugueseTitle');
        $portugueseContent = filter_input(INPUT_POST, 'portugueseContent');
        
        if($englishLevel && $points && $englishType && $englishTitle && $englishContent && $portugueseTitle && $portugueseContent){
            
            /*Save audio to system*/
            $nameAudio = md5(time().rand(0,9999)).'.mp3';
            move_uploaded_file($_FILES['audio']['tmp_name'], 'media/audio/'.$nameAudio);
            /***/
            /*Save image to system*/
            $nameImage = md5(time().rand(0,9999)).'.jpg';
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/textCover/'.$nameImage);
            /***/

            ActionadminHandler::saveNewText($englishLevel,$points,$englishType,$englishTitle,$englishContent,$portugueseTitle,$portugueseContent,$nameAudio,$nameImage,$this->loggedAdmin->id);

            $_SESSION['success'] = 'O seu texto foi criado com sucesso, você pode edita-lo na página "Editar Textos" que se encontra no menu ao lado.';
            redirect()->route('newText')->send();
            return back();
            exit;
        }else{
            $_SESSION['error'] = 'Não envie campos vazios, para ser criado um novo texto é necessario enviar todas as informações.';
            return back();
            exit;
        }

    }

    public function deleteText(Request $request){
        if($this->loggedAdmin->access < 4){
            redirect()->route('painel')->send();
            exit;
        }

        $textInfo = ActionadminHandler::getText($request->id);
        
        //delete audio
        unlink('media/audio/'.$textInfo['audio']);
        //delete image
        unlink('media/textCover/'.$textInfo['image']);

        ActionadminHandler::deleteText($request->id);

        $_SESSION['success'] = 'O texto de id '.$request->id.' foi deletado com sucesso. Não é mais possivel desfazer essa ação.';
        return back();
        exit;
    }

    public function editTextAction(Request $request){
        if($this->loggedAdmin->access < 4){
            redirect()->route('painel')->send();
            exit;
        }

        $allowed = ['image/jpeg', 'image/jpg', 'image/png'];
        $allowedAudio = ['audio/mpeg', 'audio/mp3', 'audio/wav'];
        $audioUpdated = false;
        $imageUpdated = false;

        /*Audio verify*/
        if(!empty($_FILES['audio']['name'])){
            if($_FILES['audio']['size'] > 10000000){
                $_SESSION['error'] = 'O aúdio enviado é muito grande. (maximo 5MB)';
                return back();
                exit;
            }
            if(!in_array($_FILES['audio']['type'], $allowedAudio)){
                $_SESSION['error'] = 'Envie somente aúdios mp3 ou wav';
                return back();
                exit;
            } 
            $audioUpdated = true;
        }
        /***/

        /*Image verify*/
        if(!empty($_FILES['image']['name'])){
            if($_FILES['image']['size'] > 2000000){
                $_SESSION['error'] = 'A foto enviada é muito grande. (maximo 2MB)';
                return back();
                exit;
            }

            if(!in_array($_FILES['image']['type'], $allowed)){
                $_SESSION['error'] = 'Envie somente imagens jpeg, jpg ou png';
                return back();
                exit;
            }
            $imageUpdated = true;
        }
        /***/

        $englishLevel = filter_input(INPUT_POST, 'englishLevel');
        $points = filter_input(INPUT_POST, 'points');
        $englishType = filter_input(INPUT_POST, 'englishType');
        $englishTitle = filter_input(INPUT_POST, 'englishTitle');
        $englishContent = filter_input(INPUT_POST, 'englishContent');
        $portugueseTitle = filter_input(INPUT_POST, 'portugueseTitle');
        $portugueseContent = filter_input(INPUT_POST, 'portugueseContent');
        $textToUpdate = filter_input(INPUT_POST, 'textToUpdate'); 
        
        $textInfo = ActionadminHandler::getText($textToUpdate);

        if($englishLevel && $points && $englishType && $englishTitle && $englishContent && $portugueseTitle && $portugueseContent){
            
            /*Save audio to system*/
            $nameAudio = '';
            if($audioUpdated){
                $nameAudio = md5(time().rand(0,9999)).'.mp3';
                //add new audio
                move_uploaded_file($_FILES['audio']['tmp_name'], 'media/audio/'.$nameAudio);
                //delete old audio
                unlink('media/audio/'.$textInfo['audio']);
            }
            /***/

            /*Save image to system*/
            $nameImage = '';
            if($imageUpdated){
                $nameImage = md5(time().rand(0,9999)).'.jpg';
                //add new image
                move_uploaded_file($_FILES['image']['tmp_name'], 'media/textCover/'.$nameImage);
                //delete old image
                unlink('media/textCover/'.$textInfo['image']);
            }
            /***/

            ActionadminHandler::editText($englishLevel,$points,$englishType,$englishTitle,$englishContent,$portugueseTitle,$portugueseContent,$nameAudio,$nameImage,$this->loggedAdmin->id,$audioUpdated,$imageUpdated,$textToUpdate);

            $_SESSION['success'] = 'O seu texto foi editado com sucesso.';
            redirect()->route('editTexts')->send();
            exit;
        }else{
            $_SESSION['error'] = 'Não envie campos vazios, para ser editado o texto é necessario enviar todas as informações.';
            return back();
            exit;
        }
    }

    public function changeReportStatus(Request $request){
        
        ActionadminHandler::updateReport($request->id, $request->newStatus);
        
        redirect()->route($request->newStatus)->send();
        exit;
    }
    
    public function changeSupportStatus(Request $request){
        
        ActionadminHandler::updateSupport($request->id, $request->newStatus);
        
        redirect()->route('S'.$request->newStatus)->send();
        exit;
    }

    public function saveInicialScreen(){
        $title1 = filter_input(INPUT_POST, 'title1');
        $point1 = filter_input(INPUT_POST, 'point1');
        $point2 = filter_input(INPUT_POST, 'point2');
        $point3 = filter_input(INPUT_POST, 'point3');
        $point4 = filter_input(INPUT_POST, 'point4');
        $title2 = filter_input(INPUT_POST, 'title2');
        $about = filter_input(INPUT_POST, 'about');
        $title3 = filter_input(INPUT_POST, 'title3');
        $subtitle1 = filter_input(INPUT_POST, 'subtitle1');
        $content1 = filter_input(INPUT_POST, 'content1');
        $subtitle2 = filter_input(INPUT_POST, 'subtitle2');
        $content2 = filter_input(INPUT_POST, 'content2');
        $subtitle3 = filter_input(INPUT_POST, 'subtitle3');
        $content3 = filter_input(INPUT_POST, 'content3');
        $subtitle4 = filter_input(INPUT_POST, 'subtitle4');
        $content4 = filter_input(INPUT_POST, 'content4');
        $subtitle5 = filter_input(INPUT_POST, 'subtitle5');
        $content5 = filter_input(INPUT_POST, 'content5');
        $title4 = filter_input(INPUT_POST, 'title4');
        $about2 = filter_input(INPUT_POST, 'about2');

        if($title1 && $point1 && $point2 && $point3 && $point4 && $title2 && $about && $title3 && $subtitle1 && $content1 && $subtitle2 && $content2 && $subtitle3 && $content3 && $subtitle4 && $content4 && $subtitle5 && $content5 && $title4 && $about2){

            ActionadminHandler::saveScreenInitial($title1, $point1, $point2, $point3, $point4, $title2, $about, $title3, $subtitle1, $content1, $subtitle2, $content2, $subtitle3, $content3, $subtitle4, $content4, $subtitle5, $content5, $title4, $about2);
            $_SESSION['success'] = 'A tela inicial foi alterada com sucesso.';

        }else{
            $_SESSION['error'] = 'Não foi possivel concluir a ação, pois você enviou campos em branco.';
        }
        return back();
        exit;
    }

}
