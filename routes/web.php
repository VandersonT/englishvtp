<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ErrorController;

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
Route::get('/profile/{id}', [HomeController::class, 'profile']);
Route::get('/meustextos', [HomeController::class, 'mytexts'])->name('mytexts');
Route::get('/sair', [HomeController::class, 'logout']);
/*-----------------------------------------------------------------------------------*/

/*--------------------------------Actions--------------------------------------------*/
Route::post('/envianovocomentario', [ActionController::class, 'sendNewComment']);
Route::get('/deletap/comentario/{id}', [ActionController::class, 'deleteComment']);
Route::post('/envianovosubcomentario', [ActionController::class, 'sendNewSubComment']);
Route::get('/deletap/subcomentario/{id}', [ActionController::class, 'deleteSubComment']);
Route::get('/follow/{id}', [ActionController::class, 'follow']);
Route::get('/finalizarEstudo/{textid}', [ActionController::class, 'finishStudy']);
Route::get('/salvartexto/{textid}', [ActionController::class, 'saveText']);
/*-----------------------------------------------------------------------------------*/

/*----------------------------------Ajax----------------------------------------------*/
Route::get('/ajax/rate/{id}/{rate}/{type}', [AjaxController::class, 'like']);
/*-----------------------------------------------------------------------------------*/

/*---------------------------------Error---------------------------------------------*/
Route::get('/error404', [ErrorController::class, 'error404'])->name('404');
/*-----------------------------------------------------------------------------------*/