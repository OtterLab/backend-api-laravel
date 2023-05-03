<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /** 
     * Create new Controller instance
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard when user is logged in
    */

    public function dashboard()
    {
        return view('home');
    }
}