<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\LoginHandler;
use App\Http\Handlers\HomeHandler;
use App\Http\Handlers\TrophiesHandler;
/*-----------------------------------------------------------------------------*/

class HomeController extends Controller{
    private $loggedUser;
    private $notifications;

    public function __construct(){
        
        /*Get LoggedUser*/
        $this->loggedUser = LoginHandler::checkLogin();

        if(!$this->loggedUser){
            redirect()->route('login')->send();
            exit;
        }else{
            $maxNotPerUser = 100;
            $this->notifications = HomeHandler::getNotifications($this->loggedUser->id, $maxNotPerUser);
        }
        /***/

        /*Check if this user is banned*/
        $isBanned = HomeHandler::checkBan($this->loggedUser->id);
        if($isBanned){
            redirect()->route('banned')->send();
            exit;
        }
        /***/

        /*Check if is system active*/
        $isSystemActive = HomeHandler::getSystemStatus('system');

        if(!$isSystemActive){
            redirect()->route('maintenance')->send();
            exit;
        }
        /***/

        /*check if it's a new access*/
        if(!isset($_COOKIE['lastAccess'])){
            $tomorrow = strtotime('tomorrow');
            setcookie('lastAccess', time(), $tomorrow);
            HomeHandler::sendAccessToDb();
        }
        /***/

        HomeHandler::updateLastAction($this->loggedUser->id);
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index(Request $request){

        TrophiesHandler::primordialTrophy($this->loggedUser->id);
        TrophiesHandler::staffTrophy($this->loggedUser->id, $this->loggedUser->access);
        TrophiesHandler::socialTrophy($this->loggedUser->id);
        TrophiesHandler::famousTrophy($this->loggedUser->id);
        TrophiesHandler::peoplesVoiceTrophy($this->loggedUser->id);
        TrophiesHandler::studiousTrophy($this->loggedUser->id);

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

        $americanTextRecommendation = HomeHandler::getAssistentRecomendation($this->loggedUser, 'american');

        $britishTextRecommendation = HomeHandler::getAssistentRecomendation($this->loggedUser, 'british');

        $notificationOnScreen = HomeHandler::getThisUserNotification($this->loggedUser->id);

        return view('home',[
            'selected' => 'home',
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'texts' => $texts,
            'filter' => $filter,
            'page' => $page,
            'totalPage' => $totalPage,
            'availableTexts' => $totalTextsWithFilter,
            'americanTextRecommendation' => $americanTextRecommendation,
            'britishTextRecommendation' => $britishTextRecommendation,
            'notificationOnScreen' => $notificationOnScreen
        ]);

    }

    public function openText($textid){

        $error = '';
        if(!empty($_SESSION['error'])){
            $error = $_SESSION['error'];
            $_SESSION['error'] = '';
        }

        $success = '';
        if(!empty($_SESSION['success'])){
            $success = $_SESSION['success'];
            $_SESSION['success'] = '';
        }

        $exiled = '';
        if(!empty($_SESSION['exiled'])){
            $exiled = $_SESSION['exiled'];
            $_SESSION['exiled'] = '';
        }

        /*Comments per page*/
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 20;

        $totalComments = HomeHandler::countAllComments($textid);
        $totalPages = ceil($totalComments / $perPage);
        /***/
        
        $totalCommentsAndSub = HomeHandler::countAllCommentsAndSubComments($textid);

        $text = HomeHandler::getText($textid);
        $comments = HomeHandler::getTextComments($textid, $this->loggedUser,$page, $perPage);
        $subComments = HomeHandler::getTextSubComments($textid, $this->loggedUser);

        if(!$text){
            return back();//return because profile don't exists
        }

        $userStudiedThisText = HomeHandler::userStudiedThisText($textid, $this->loggedUser->id);
        $userSavedThisText = HomeHandler::userSavedThisText($textid, $this->loggedUser->id);

        return view('textSingle',[
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'text' => $text,
            'comments' => $comments,
            'totalComments' => $totalCommentsAndSub,
            'subComments' => $subComments,
            'selected' => 'none',
            'totalPages' => $totalPages,
            'page' => $page,
            'success' => $success,
            'error' => $error,
            'exiled' => $exiled,
            'userStudiedThisText' => $userStudiedThisText,
            'userSavedThisText' => $userSavedThisText
        ]);
    }

    public function profile(Request $request){

        /*your interactions per page*/
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 30;

        $interactions = HomeHandler::getAllInteractions($request->id, $page, $perPage);

        $totalInteractions = HomeHandler::getTotalInteractions($request->id);

        $totalPages = ceil($totalInteractions / $perPage);
        /***/

        $infoProfile = HomeHandler::getInfoProfile($request->id);
        $userComments = HomeHandler::getUserComments($request->id);
        $follower = HomeHandler::getTotalFollowers($request->id);
        $following = HomeHandler::getTotalFollowing($request->id);
        $trophies = HomeHandler::getTrophies($request->id);
        $userFollowsThisPerson = HomeHandler::userFollowsThisPerson($request->id, $this->loggedUser->id);

        if(!$infoProfile){
            return back();//return because profile don't exists
        }

        return view('profile',[
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'profile',
            'infoProfile' => $infoProfile,
            'userComments' => $userComments,
            'follower' => $follower,
            'following' => $following,
            'trophies' => $trophies,
            'interactions' => $interactions,
            'userFollowsThisPerson' => $userFollowsThisPerson,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function mytexts(){

        $textsStudies = HomeHandler::getAllTextsStudies($this->loggedUser->id);
        $textsSaveds = HomeHandler::getAllTextsSaved($this->loggedUser->id);

        return view('mytexts',[
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'mytexts',
            'textsStudies' => $textsStudies,
            'textsSaveds' => $textsSaveds
        ]);
    }

    public function editProfile(){

        $success = '';
        if(!empty($_SESSION['success'])){
            $success = $_SESSION['success'];
            $_SESSION['success'] = '';
        }
        $error = '';
        if(!empty($_SESSION['error'])){
            $error = $_SESSION['error'];
            $_SESSION['error'] = '';
        }

        return view('editProfile',[
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'profile',
            'success' => $success,
            'error' => $error
        ]);
    }

    public function following(Request $request){

        $infoProfile = HomeHandler::getInfoProfile($request->id);

        /*your interactions per page*/
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 30;

        $totalFollowing = HomeHandler::getTotalFollowing($infoProfile['id']);

        $totalPages = ceil($totalFollowing / $perPage);
        /***/

        $following = HomeHandler::getPeopleFollowed($infoProfile, $this->loggedUser->id, $page, $perPage);

        return view('following',[
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'profile',
            'infoProfile' => $infoProfile,
            'following' => $following,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function followers(Request $request){

        $infoProfile = HomeHandler::getInfoProfile($request->id);
        

        /*your interactions per page*/
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 30;

        $totalFollowers = HomeHandler::getTotalFollowers($infoProfile['id']);

        $totalPages = ceil($totalFollowers / $perPage);
        /***/


        $followers = HomeHandler::getFollowers($infoProfile, $this->loggedUser->id, $page, $perPage);

        return view('followers',[
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'profile',
            'infoProfile' => $infoProfile,
            'followers' => $followers,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function support(){

        $error = '';
        if(!empty($_SESSION['error'])){
            $error = $_SESSION['error'];
            $_SESSION['error'] = '';
        }

        $success = '';
        if(!empty($_SESSION['success'])){
            $success = $_SESSION['success'];
            $_SESSION['success'] = '';
        }

        $exiled = '';
        if(!empty($_SESSION['exiled'])){
            $exiled = $_SESSION['exiled'];
            $_SESSION['exiled'] = '';
        }

        $supports = HomeHandler::getMySupports($this->loggedUser->id);

        return view('support', [
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'support',
            'supports' => $supports,
            'error' => $error,
            'exiled' => $exiled,
            'success' => $success
        ]);
    }

    public function viewSupport(Request $request){

        $error = '';
        if(!empty($_SESSION['error'])){
            $error = $_SESSION['error'];
            $_SESSION['error'] = '';
        }

        $success = '';
        if(!empty($_SESSION['success'])){
            $success = $_SESSION['success'];
            $_SESSION['success'] = '';
        }

        $exiled = '';
        if(!empty($_SESSION['exiled'])){
            $exiled = $_SESSION['exiled'];
            $_SESSION['exiled'] = '';
        }

        $supportInfo = HomeHandler::getSupportSingle($request->id, $this->loggedUser->id);

        $replys = HomeHandler::getSupportReplys($supportInfo['id']);

        if(!$supportInfo){
            redirect()->route('404')->send();
        }

        return view('supportSingle', [
            'user' => $this->loggedUser,
            'notifications' => $this->notifications,
            'selected' => 'support',
            'supportInfo' => $supportInfo,
            'replys' => $replys,
            'error' => $error,
            'exiled' => $exiled,
            'success' => $success
        ]);
    }

    public function logout(){
        $_SESSION['token'] = '';

        if(isset($_COOKIE['token'])){
            setcookie('token', '', time()-3600);
        }

        redirect()->route('login')->send();
    }

}
