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

    public function profile(Request $request){
        
        $infoProfile = AdminHandler::getInfoProfile($request->id);
        
        return view('admin/profile',[
            'user' => $this->loggedAdmin,
            'selected' => 'profile',
            'infoProfile' => $infoProfile
        ]);
    }

    public function users(){

        $users = AdminHandler::getAllUsers();

        return view('admin/users',[
            'user' => $this->loggedAdmin,
            'selected' => 'users',
            'users' => $users
        ]);
    }

    public function staffs(){

        $staffs = AdminHandler::getAllStaffs();

        return view('admin/staffs',[
            'user' => $this->loggedAdmin,
            'selected' => 'staffs',
            'staffs' => $staffs
        ]);
    }

    public function logout(){
        $_SESSION['tokenAdmin'] = '';

        if(isset($_COOKIE['tokenAdmin'])){
            setcookie('tokenAdmin', '', time()-3600);
        }

        redirect()->route('loginAdmin')->send();
    }
}
