<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
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


/*----------------------------------PEGES--------------------------------------------*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sair', [HomeController::class, 'logout']);
Route::get('/texto/{textid}', [HomeController::class, 'openText'])->name('text');
Route::get('/profile/{id}', [HomeController::class, 'profile']);
/*-----------------------------------------------------------------------------------*/

/*--------------------------------Actions--------------------------------------------*/
Route::get('/ajax/rate/{id}/{rate}/{type}', [AjaxController::class, 'like']);
Route::post('/envianovocomentario', [HomeController::class, 'sendNewComment']);
Route::get('/deletap/comentario/{id}', [HomeController::class, 'deleteComment']);
Route::post('/envianovosubcomentario', [HomeController::class, 'sendNewSubComment']);
Route::get('/deletap/subcomentario/{id}', [HomeController::class, 'deleteSubComment']);
Route::get('/follow/{id}', [HomeController::class, 'follow']);
/*-----------------------------------------------------------------------------------*/

/*---------------------------------Error---------------------------------------------*/
Route::get('/error404', [ErrorController::class, 'error404'])->name('404');
/*-----------------------------------------------------------------------------------*/