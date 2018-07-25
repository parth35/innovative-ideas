<?php

namespace App\Http\Controllers;
use Auth;
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
    public function doLogin(Request $r)
    {
        $input = $r->all();
        $validatedData = $r->validate([
            'email'         => 'required|email',
            'password'      => 'required'
        ]);

        $userdata = array(
            'email'     => $input['email'],
            'password'  => $input['password']
        );

        if (Auth::attempt($userdata)) {
            $message = 'Login successfully.';
            return redirect('/admin/dashboard')->with('success', $message);
        } else {
            $message = 'Login failed.';
            return redirect('/admin/login')->with('error', $message);
        }
    }

    /**
	 * This function is used for logout process.
     * 
     * @param request $r
	 * @version 1.0.0
	 * @author Parth
	 * @return redirect 'login'
	 */
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
