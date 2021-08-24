<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
use App\Http\Handlers\HomeHandler;
/*-----------------------------------------------------------------------------*/

class HomeController extends Controller{
    private $loggedUser;

    public function __construct(){
        $this->loggedUser = LoginHandler::checkLogin();

        if(!$this->loggedUser){
            redirect()->route('login')->send();
        }
    }

    public function index(Request $request){
        

        /*--------------------------------TEXTS_FILTER-------------------------------------------------*/
        $filter['type'] = 'americano';
        $filter['levels'] = array('básico','intermediário','avançado','superavançado');

        if($_GET){
            $type = filter_input(INPUT_GET, 'type');
            $level1 = filter_input(INPUT_GET, 'level1');
            $level2 = filter_input(INPUT_GET, 'level2');
            $level3 = filter_input(INPUT_GET, 'level3');
            $level4 = filter_input(INPUT_GET, 'level4');

            $filter['type'] = $type;
            $filter['levels'] = array($level1,$level2,$level3,$level4);
        }
        /*---------------------------------------------------------------------------------------------*/

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        
        $perPage = 21;
        
        $texts = HomeHandler::getTexts($filter, $page, $perPage);

        $totalTextsWithFilter = HomeHandler::getAllTextWithFilter($filter);

        $totalPage = ceil($totalTextsWithFilter / $perPage);

        return view('home',[
            'selected' => 'home',
            'user' => $this->loggedUser,
            'texts' => $texts,
            'filter' => $filter,
            'page' => $page,
            'totalPage' => $totalPage,
            'availableTexts' => $totalTextsWithFilter
        ]);

    }

    public function logout(){
        $_SESSION['token'] = '';

        if(isset($_COOKIE['token'])){
            setcookie('token', '', time()-3600);
        }

        redirect()->route('login')->send();
    }

    public function openText($textid){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        
        $perPage = 20;
        
        $text = HomeHandler::getText($textid);
        $comments = HomeHandler::getTextComments($textid, $this->loggedUser,$page, $perPage);
        $subComments = HomeHandler::getTextSubComments($textid, $this->loggedUser);

        if(!$text){
            redirect()->route('home')->send();//redireciona para o erro aqui
        }

        $totalComments = HomeHandler::countAllComments($textid);

        $totalPages = ceil($totalComments / $perPage);

        return view('textSingle',[
            'user' => $this->loggedUser,
            'text' => $text,
            'comments' => $comments,
            'totalComments' => $totalComments,
            'subComments' => $subComments,
            'selected' => 'none',
            'totalPages' => $totalPages,
            'page' => $page,
            'flash' => $flash
        ]);
    }

    public function sendNewComment(){
        $message = filter_input(INPUT_POST, 'newcomment', FILTER_SANITIZE_SPECIAL_CHARS);
        $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($message && $textid){

            HomeHandler::sendNewComment($message, $textid, $this->loggedUser->id);
            $_SESSION['flash'] = 'Comentário adicionado com sucesso.';

        }
        return redirect()->route('text', $textid)->send();
    }

}
