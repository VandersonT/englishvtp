<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginadminController;
use App\Http\Controllers\Admin\ActionadminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*----------------------------------LOGIN-------------------------------------------*/
Route::get('/inicio', [LoginController::class, 'initial']);
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginAction']);
Route::get('/cadastrar', [LoginController::class, 'register'])->name('register');
Route::post('/cadastrar', [LoginController::class, 'registerAction']);
/*-----------------------------------------------------------------------------------*/


/*----------------------------------PAGES--------------------------------------------*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/texto/{textid}', [HomeController::class, 'openText'])->name('text');
Route::get('/perfil/{id}', [HomeController::class, 'profile']);
Route::get('/meustextos', [HomeController::class, 'mytexts'])->name('mytexts');
Route::get('/sair', [HomeController::class, 'logout']);
Route::get('/editar/perfil', [HomeController::class, 'editProfile'])->name('profile');
Route::get('/perfil/seguindo/{id}', [HomeController::class, 'following']);
Route::get('/perfil/seguidores/{id}', [HomeController::class, 'followers']);
Route::get('/suporte', [HomeController::class, 'support'])->name('support');
Route::get('/suporte/{id}', [HomeController::class, 'viewSupport']);
/*-----------------------------------------------------------------------------------*/

/*--------------------------------Actions--------------------------------------------*/
Route::post('/envianovocomentario', [ActionController::class, 'sendNewComment']);
Route::get('/deletap/comentario/{id}', [ActionController::class, 'deleteComment']);
Route::post('/envianovosubcomentario', [ActionController::class, 'sendNewSubComment']);
Route::get('/deletap/subcomentario/{id}', [ActionController::class, 'deleteSubComment']);
Route::get('/follow/{id}', [ActionController::class, 'follow']);
Route::get('/finalizarEstudo/{textid}', [ActionController::class, 'finishStudy']);
Route::get('/salvartexto/{textid}', [ActionController::class, 'saveText']);
Route::post('/atualizaperfil', [ActionController::class, 'updateProfile']);
Route::post('/novoSuporte', [ActionController::class, 'newSupport']);
Route::post('/respondeSuporte/{id}', [ActionController::class, 'replySupport']);
Route::get('/reportar/{type}/{id}', [ActionController::class, 'reportComment']);
/*-----------------------------------------------------------------------------------*/

/*----------------------------------Ajax----------------------------------------------*/
Route::get('/ajax/rate/{id}/{rate}/{type}', [AjaxController::class, 'like']);
Route::get('/viewedNotification/{idnot}', [AjaxController::class, 'viewedNotification']);
/*-----------------------------------------------------------------------------------*/

/*---------------------------------Error---------------------------------------------*/
Route::get('/error404', [ErrorController::class, 'error404'])->name('404');
Route::fallback(function(){
    return view('404');
});
Route::get('/manutenção', [ErrorController::class, 'maintenance'])->name('maintenance');
Route::get('/banned', [ErrorController::class, 'banned'])->name('banned');
Route::get('/finalizaSessao', [ErrorController::class, 'endSection']);
/*-----------------------------------------------------------------------------------*/





/*---------------------------------Painel--------------------------------------------*/
Route::prefix('Painel')->group(function(){
    /*Home*/
    Route::get('/', [AdminController::class, 'index'])->name('painel');
    Route::get('/paginas', [AdminController::class, 'pages']);
    Route::get('/notificações', [AdminController::class, 'userNotification']);
    Route::get('/sair', [AdminController::class, 'logout']);
    Route::get('/perfil/{id}', [AdminController::class, 'profile']);
    Route::get('/usuarios', [AdminController::class, 'users']);
    Route::get('/staffs', [AdminController::class, 'staffs']);
    Route::get('/novoStaff', [AdminController::class, 'newStaff']);
    Route::get('/banidos', [AdminController::class, 'bans']);
    Route::get('/banir', [AdminController::class, 'addBan']);
    Route::get('/exilio', [AdminController::class, 'exile']);
    Route::get('/exilar', [AdminController::class, 'addExile']);
    Route::get('/novoTexto', [AdminController::class, 'newText'])->name('newText');
    Route::get('/editarTextos', [AdminController::class, 'editTexts'])->name('editTexts');
    Route::get('/editarTexto/{id}', [AdminController::class, 'editTextSingle']);
    Route::get('/reportes/pendentes', [AdminController::class, 'reportsPendents'])->name('pendente');
    Route::get('/reportes/resolvidos', [AdminController::class, 'reportsResolved'])->name('resolvido');
    Route::get('/reportes/ignorados', [AdminController::class, 'reportsIgnored'])->name('ignorado');
    Route::get('/reporte/{type}/{id}', [AdminController::class, 'reportOpen']);
    Route::get('/suportes/pendentes', [AdminController::class, 'supportsPendents'])->name('Spendente');
    Route::get('/suportes/resolvidos', [AdminController::class, 'supportsResolved'])->name('Sresolvido');
    Route::get('/suportes/ignorados', [AdminController::class, 'supportsIgnored'])->name('Signorado');
    Route::get('/suporte/{id}', [AdminController::class, 'supportOpen']);
    /*Login*/
    Route::get('/login', [LoginadminController::class, 'login'])->name('loginAdmin');
    Route::post('/login', [LoginadminController::class, 'loginAction']);
    /***/
    /*Action*/
    Route::get('/controles/{btn}/{action}', [ActionadminController::class, 'mainControls']);
    Route::post('/mudarAcesso/{id}', [ActionadminController::class, 'changeAccess']);
    Route::get('/removeBan/{id}', [ActionadminController::class, 'deleteBan']);
    Route::post('/banir', [ActionadminController::class, 'banAction']);
    Route::post('/exilar', [ActionadminController::class, 'exileAction']);
    Route::get('/removeExilio/{id}', [ActionadminController::class, 'deleteExile']);
    Route::post('/enviaNovoTexto', [ActionadminController::class, 'sendNewText']);
    Route::post('/editarTextoAcao', [ActionadminController::class, 'editTextAction']);
    Route::get('/removeTexto/{id}', [ActionadminController::class, 'deleteText']);
    Route::get('/mudarStatusReporte/{newStatus}/{id}', [ActionadminController::class, 'changeReportStatus']);
    Route::get('/mudarStatusSuporte/{newStatus}/{id}', [ActionadminController::class, 'changeSupportStatus']);
    Route::post('/enviaNotificação', [ActionadminController::class, 'sendNotification']);
    /****/
});
/*-----------------------------------------------------------------------------------*/