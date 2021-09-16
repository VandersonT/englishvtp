<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
session_start();

/*-----------------------------Handlers----------------------------------------*/
use App\Http\Handlers\admin\LoginAdminHandler;
use App\Http\Handlers\admin\AdminHandler;
/*-----------------------------------------------------------------------------*/

class AdminController extends Controller
{
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

    public function index(){

        $totalAccess = AdminHandler::getTotalAccess();
        $usersOn = AdminHandler::getUsersOn();
        $totalTexts =  AdminHandler::getTotalTexts();
        $totalAccounts =  AdminHandler::getTotalAccounts();
        $mostSavedTexts = AdminHandler::getMostSavedTexts();
        $mostStudiedTexts = AdminHandler::getMostStudiedTexts();
        $howManyOfEachType = AdminHandler::getHowManyOfEachType();
        $systemInfo = AdminHandler::getSystemInfo();

        return view('admin/home',[
            'user' => $this->loggedAdmin,
            'selected' => 'dashboard',
            'mostSavedTexts' => $mostSavedTexts,
            'mostStudiedTexts' => $mostStudiedTexts,
            'howManyOfEachType' => $howManyOfEachType,
            'totalAccess' => $totalAccess,
            'totalTexts' => $totalTexts,
            'totalAccounts' => $totalAccounts,
            'usersOn' => $usersOn,
            'systemInfo' => $systemInfo
        ]);
    }

    public function pages(){
        return view('admin/pages',[
            'user' => $this->loggedAdmin,
            'selected' => 'pages'
        ]);
    }

    public function editInicialScreen(){
        
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

        $currentInformation = AdminHandler::getInfoPageInitial();
        
        return view('admin/editInicialScreen',[
            'user' => $this->loggedAdmin,
            'selected' => 'pages',
            'currentInformation' => $currentInformation,
            'success' => $success,
            'error' => $error
        ]);
    }

    public function userNotification(){

        if($this->loggedAdmin->access < 3){
            return redirect()->route('painel')->send();
        }

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

        return view('admin/userNotification',[
            'user' => $this->loggedAdmin,
            'selected' => 'usersNotification',
            'success' => $success,
            'error' => $error
        ]);
    }

    public function manageNotifications(){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $wantedNotification = '';
        if($_GET){
            $wantedNotification = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $notifications = AdminHandler::getWantedUserNotification($wantedNotification);
        }else{
            $notifications = AdminHandler::getAllUsersNotification();
        }

        $globalNotifications = AdminHandler::getGlobalNotification();
        
        return view('admin/managerNotifications',[
            'user' => $this->loggedAdmin,
            'selected' => 'usersNotification',
            'wantedNotification' => $wantedNotification,
            'notifications' => $notifications,
            'globalNotifications' => $globalNotifications,
            'flash' => $flash
        ]);
    }

    public function profile(Request $request){
        
        $infoProfile = AdminHandler::getInfoProfile($request->id);
        
        return view('admin/profile',[
            'user' => $this->loggedAdmin,
            'selected' => 'profile',
            'infoProfile' => $infoProfile
        ]);
    }

    public function users(Request $request){

        $wantedUser = '';
        if($_GET){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $users = AdminHandler::getWantedUser($wantedUser);
        }else{
            $users = AdminHandler::getAllUsers();
        }
        
        return view('admin/users',[
            'user' => $this->loggedAdmin,
            'selected' => 'users',
            'users' => $users,
            'wantedUser' => $wantedUser
        ]);
    }

    public function staffs(){

        $wantedUser = '';
        if($_GET){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $staffs = AdminHandler::getWantedStaff($wantedUser);
        }else{
            $staffs = AdminHandler::getAllStaffs();
        }

        return view('admin/staffs',[
            'user' => $this->loggedAdmin,
            'selected' => 'staffs',
            'staffs' => $staffs,
            'wantedUser' => $wantedUser
        ]);
    }

    public function newStaff(){

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

        $idSearch = 0;
        $userFound = [];
        if($_GET){
            $idSearch = filter_input(INPUT_GET, 'idSearch', FILTER_SANITIZE_SPECIAL_CHARS);
            $userFound = AdminHandler::getWantedUserSingle($idSearch);
        }

        return view('admin/newStaff',[
            'user' => $this->loggedAdmin,
            'selected' => 'staffs',
            'userFound' => $userFound,
            'idSearch' => $idSearch,
            'success' => $success,
            'error' => $error
        ]);
    }

    public function bans(){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $wantedUser = '';
        if($_GET){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $users = AdminHandler::getWantedUserBan($wantedUser);
        }else{
            $users = AdminHandler::getAllUserBan();
        }

        return view('admin/bans',[
            'user' => $this->loggedAdmin,
            'selected' => 'bans',
            'wantedUser' => $wantedUser,
            'users' => $users,
            'flash' => $flash
        ]);
    }

    public function addBan(){
        
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

        return view('admin/newBan',[
            'user' => $this->loggedAdmin,
            'selected' => 'bans',
            'success' => $success,
            'error' => $error
        ]);
    }

    public function exile(){

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $wantedUser = '';
        if($_GET){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $users = AdminHandler::getWantedUserExile($wantedUser);
        }else{
            $users = AdminHandler::getAllUserExile();
        }

        return view('admin/exile',[
            'user' => $this->loggedAdmin,
            'selected' => 'exile',
            'wantedUser' => $wantedUser,
            'users' => $users,
            'flash' => $flash
        ]);
    }

    public function addExile(){
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

        return view('admin/newExile',[
            'user' => $this->loggedAdmin,
            'selected' => 'exile',
            'success' => $success,
            'error' => $error
        ]);
    }

    public function newText(){

        if($this->loggedAdmin->access < 4){
            redirect()->route('painel')->send();
            exit;
        }

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


        return view('admin/newText',[
            'user' => $this->loggedAdmin,
            'selected' => 'newText',
            'success' => $success,
            'error' => $error
        ]);
    }

    public function editTexts(){

        if($this->loggedAdmin->access < 4){
            redirect()->route('painel')->send();
            exit;
        }

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

        $wantedText = '';
        if($_GET){
            $wantedText = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $texts = AdminHandler::getWantedText($wantedText);
        }else{
            $texts = AdminHandler::getAllTexts();
        }

        return view('admin/editTexts',[
            'user' => $this->loggedAdmin,
            'selected' => 'editTexts',
            'wantedText' => $wantedText,
            'texts' => $texts,
            'success' => $success,
            'error' => $error
        ]);
    }

    public function editTextSingle(Request $request){
        if($this->loggedAdmin->access < 4){
            redirect()->route('painel')->send();
            exit;
        }

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

        $text = AdminHandler::getText($request->id);
        
        return view('admin/editText',[
            'user' => $this->loggedAdmin,
            'selected' => 'editTexts',
            'text' => $text,
            'success' => $success,
            'error' => $error
        ]);
    }

    public function reportsPendents(){
        
        $reports = AdminHandler::getAllReports('pendente');

        return view('admin/reportsP',[
            'user' => $this->loggedAdmin,
            'selected' => 'reportsP',
            'reports' => $reports
        ]);
    }

    public function reportsResolved(){
        
        $reports = AdminHandler::getAllReports('resolvido');

        return view('admin/reportsR',[
            'user' => $this->loggedAdmin,
            'selected' => 'reportsR',
            'reports' => $reports
        ]);
    }

    public function reportsIgnored(){
        
        $reports = AdminHandler::getAllReports('ignorado');

        return view('admin/reportsI',[
            'user' => $this->loggedAdmin,
            'selected' => 'reportsI',
            'reports' => $reports
        ]);
    }

    public function reportOpen(Request $request){

        $report = AdminHandler::getReport($request->id, $request->type);

        return view('admin/reportOpen',[
            'user' => $this->loggedAdmin,
            'selected' => 'none',
            'report' => $report
        ]);
    }

    public function supportsPendents(){

        $supports = AdminHandler::getAllSupports('pendente');

        return view('admin/supportsP',[
            'user' => $this->loggedAdmin,
            'selected' => 'supportsP',
            'supports' => $supports
        ]);
    }

    public function supportsResolved(){

        $supports = AdminHandler::getAllSupports('resolvido');

        return view('admin/supportsR',[
            'user' => $this->loggedAdmin,
            'selected' => 'supportsR',
            'supports' => $supports
        ]);
    }

    public function supportsIgnored(){

        $supports = AdminHandler::getAllSupports('ignorado');

        return view('admin/supportsI',[
            'user' => $this->loggedAdmin,
            'selected' => 'supportsI',
            'supports' => $supports
        ]);
    }

    public function supportOpen(Request $request){

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

        $support = AdminHandler::getSupport($request->id);
        $supportReplys = AdminHandler::getSupportReplys($request->id);

        if($support['status'] == 'pendente'){
            $selected = 'supportsP';
        }
        if($support['status'] == 'resolvido'){
            $selected = 'supportsR';
        }
        if($support['status'] == 'ignorado'){
            $selected = 'supportsI';
        }

        return view('admin/supportOpen',[
            'user' => $this->loggedAdmin,
            'selected' => $selected,
            'support' => $support,
            'supportReplys' => $supportReplys,
            'success' => $success,
            'error' => $error
        ]);
    }

    public function logout(){
        $_SESSION['tokenAdmin'] = '';

        if(isset($_COOKIE['tokenAdmin'])){
            setcookie('tokenAdmin', '', time()-3600);
        }

        redirect()->route('loginAdmin')->send();
        exit;
    }
}
