<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        $title = 'Dashboard';
        $users = \App\User::limit(8)->orderBy('id','DESC')->get();
        return view('admin.modules.dashboard',['title' => $title, 'users' => $users]);
    }
}
