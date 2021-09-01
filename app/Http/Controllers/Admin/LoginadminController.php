<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginadminController extends Controller
{
    public function teste(){
        return view('admin/loginAdmin');
    }
}
