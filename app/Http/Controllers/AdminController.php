<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view("admin.home");
    }

    public function account(){
        return view("admin.account");
    }
}
