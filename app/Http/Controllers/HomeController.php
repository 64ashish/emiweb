<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        return "Show login page";
    }

    public function home(){
        return "post login page";
    }
}
