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
        
        if($this->loggedAdmin->access < 4){
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
            'selected' => 'none',
            'infoProfile' => $infoProfile
        ]);
    }

    public function users(Request $request){

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $wantedUser = '';
        if($_GET){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $users = AdminHandler::getWantedUser($wantedUser, $page, $perPage);
            $totalUsers = AdminHandler::getTotalUsersWanted($wantedUser);
        }else{
            $users = AdminHandler::getAllUsers($page, $perPage);
            $totalUsers = AdminHandler::getTotalUsers();
        }

        $totalPages = ceil($totalUsers / $perPage);
        
        return view('admin/users',[
            'user' => $this->loggedAdmin,
            'selected' => 'users',
            'users' => $users,
            'wantedUser' => $wantedUser,
            'totalPages' => $totalPages,
            'page' => $page,
            'totalUsers' => $totalUsers
        ]);
    }

    public function staffs(){

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $wantedUser = '';
        if(!empty($_GET['search'])){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $staffs = AdminHandler::getWantedStaff($wantedUser, $page, $perPage);
            $totalStaffs = AdminHandler::getTotalStaffsWanted($wantedUser);
        }else{
            $staffs = AdminHandler::getAllStaffs($page, $perPage);
            $totalStaffs = AdminHandler::getTotalStaffs();
        }

        $totalPages = ceil($totalStaffs / $perPage);

        return view('admin/staffs',[
            'user' => $this->loggedAdmin,
            'selected' => 'staffs',
            'staffs' => $staffs,
            'wantedUser' => $wantedUser,
            'totalPages' => $totalPages,
            'page' => $page,
            'totalStaffs' => $totalStaffs
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

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $wantedUser = '';
        if(!empty($_GET['search'])){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $users = AdminHandler::getWantedUserBan($wantedUser, $page, $perPage);
            $totalUserBan = AdminHandler::getTotalUserBanWanted($wantedUser);
        }else{
            $users = AdminHandler::getAllUserBan($page, $perPage);
            $totalUserBan = AdminHandler::getTotalUserBan();
        }

        $totalPages = ceil($totalUserBan / $perPage);

        return view('admin/bans',[
            'user' => $this->loggedAdmin,
            'selected' => 'bans',
            'wantedUser' => $wantedUser,
            'users' => $users,
            'flash' => $flash,
            'totalPages' => $totalPages,
            'page' => $page,
            'totalUserBan' => $totalUserBan
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

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $wantedUser = '';
        if(!empty($_GET['search'])){
            $wantedUser = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
            $users = AdminHandler::getWantedUserExile($wantedUser, $page, $perPage);
            $totalUserExiled = AdminHandler::getTotalUserExiledWanted($wantedUser);
        }else{
            $users = AdminHandler::getAllUserExile($page, $perPage);
            $totalUserExiled = AdminHandler::getTotalUserExiled();
        }

        $totalPages = ceil($totalUserExiled / $perPage);

        return view('admin/exile',[
            'user' => $this->loggedAdmin,
            'selected' => 'exile',
            'wantedUser' => $wantedUser,
            'users' => $users,
            'flash' => $flash,
            'totalPages' => $totalPages,
            'page' => $page,
            'totalUserExiled' => $totalUserExiled
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
        
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $totalReportsPendents = AdminHandler::getTotalReportsType('pendente');

        $totalPages = ceil($totalReportsPendents / $perPage);

        $reports = AdminHandler::getAllReports('pendente', $page, $perPage);

        return view('admin/reportsP',[
            'user' => $this->loggedAdmin,
            'selected' => 'reportsP',
            'reports' => $reports,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function reportsResolved(){
        
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $totalReportsResolved = AdminHandler::getTotalReportsType('resolvido');

        $totalPages = ceil($totalReportsResolved / $perPage);

        $reports = AdminHandler::getAllReports('resolvido', $page, $perPage);

        return view('admin/reportsR',[
            'user' => $this->loggedAdmin,
            'selected' => 'reportsR',
            'reports' => $reports,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function reportsIgnored(){
        
        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $totalReportsIgnored = AdminHandler::getTotalReportsType('ignorado');

        $totalPages = ceil($totalReportsIgnored / $perPage);

        $reports = AdminHandler::getAllReports('ignorado', $page, $perPage);

        return view('admin/reportsI',[
            'user' => $this->loggedAdmin,
            'selected' => 'reportsI',
            'reports' => $reports,
            'totalPages' => $totalPages,
            'page' => $page
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

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $totalSupportsPendents = AdminHandler::getTotalSupportsType('pendente');

        $totalPages = ceil($totalSupportsPendents / $perPage);

        $supports = AdminHandler::getAllSupports('pendente', $page, $perPage);

        return view('admin/supportsP',[
            'user' => $this->loggedAdmin,
            'selected' => 'supportsP',
            'supports' => $supports,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function supportsResolved(){

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $totalSupportsResolved = AdminHandler::getTotalSupportsType('resolvido');

        $totalPages = ceil($totalSupportsResolved / $perPage);

        $supports = AdminHandler::getAllSupports('resolvido', $page, $perPage);

        return view('admin/supportsR',[
            'user' => $this->loggedAdmin,
            'selected' => 'supportsR',
            'supports' => $supports,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function supportsIgnored(){

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 100;

        $totalSupportsIgnored = AdminHandler::getTotalSupportsType('ignorado');

        $totalPages = ceil($totalSupportsIgnored / $perPage);

        $supports = AdminHandler::getAllSupports('ignorado', $page, $perPage);

        return view('admin/supportsI',[
            'user' => $this->loggedAdmin,
            'selected' => 'supportsI',
            'supports' => $supports,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function supportOpen(Request $request){

        $page = 1;
        if(!empty($_GET['pg'])){
            $page = addslashes($_GET['pg']);
        }
        $perPage = 20;

        $totalReplysSupports = AdminHandler::getTotalReplysSupport($request->id, $this->loggedAdmin->id);

        $totalPages = ceil($totalReplysSupports / $perPage);

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
        $supportReplys = AdminHandler::getSupportReplys($request->id, $page, $perPage);

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
            'error' => $error,
            'totalPages' => $totalPages,
            'page' => $page
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
