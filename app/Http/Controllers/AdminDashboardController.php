<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    public function dashboard()
    {
        $title = 'Dashboard';
        return view('admin.modules.dashboard',['title' => $title]);
    }
}
