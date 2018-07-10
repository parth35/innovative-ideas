<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    //
    public function users()
    {
        $title = 'Users';
        $users = \App\User::get();
        return view('admin.modules.users.list',['title' => $title, 'users' => $users]);
    }
}
