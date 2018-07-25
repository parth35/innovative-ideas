<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
	 * This function is used for view login page.
     * 
	 * @version 1.0.0
	 * @author Parth
	 * @return view 'admin.auth.login'
	 */
    public function login()
    {
        $title = 'Innovative Ideas - Login';
        return view('admin.auth.login',['title' => $title]);
    }

    /**
	 * This function is used for login process.
     * 
     * @param request $r
	 * @version 1.0.0
	 * @author Parth
	 * @return redirect 'dashboard'
	 */
    public function doLogin(request $r)
    {
        $data = $r->all();
    }
}
