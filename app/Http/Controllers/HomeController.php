<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\LoginHandler;

class HomeController extends Controller
{
    
    public function __construct(){
        
    }

    public function index(){
        return view('home');
    }

}
