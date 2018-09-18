<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class HomeController extends Controller
{
    /**
     * This function is used for view home page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'home'
     */
    public function Home()
    {
        $title = 'Home';
        $count = 3;
        if(\App\Photo::where('approve','yes')->where('show_in_slider','yes')->count()>=$count)
        {
            $photos = \App\Photo::where('approve','yes')->where('show_in_slider','yes')->get()->random($count);
        }
        else{
            $photos = '';
        }
        if(\App\Photo::where('approve','yes')->where('show_in_slider','yes')->count()>0)
        {
            $section_back_image = \App\Photo::where('approve','yes')->where('show_in_slider','yes')->inRandomOrder()->first();
        }
        else{
            $section_back_image = '';
        }
        return view('home',['photos' => $photos, 'title' => $title, 'section_back_image' => $section_back_image]);
    }

    /**
     * This function is used for view about page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'about'
     */
    public function about()
    {
        return view('about');
    }

    /**
     * This function is used for view photos page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'photos'
     */
    public function photos()
    {
        return view('photos');
    }

    /**
     * This function is used for view send_photo page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'send_photo'
     */
    public function send_photo()
    {
        return view('send_photo');
    }

    /**
     * This function is used for view log_in page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'log_in'
     */
    public function log_in()
    {
        $title = 'Login';
        if(\App\Photo::where('approve','yes')->where('show_in_slider','yes')->count()>0)
        {
            $section_back_image = \App\Photo::where('approve','yes')->where('show_in_slider','yes')->inRandomOrder()->first();
        }
        else{
            $section_back_image = '';
        }
        return view('log_in',['title' => $title, 'section_back_image' => $section_back_image]);
    }
    
    public function socialLogin($service)
	{
		return Socialite::driver($service)->redirect();
	}

	/**
	 * Obtain the user information from Social Logged in.
	 * @param $social
	 * @return Response
	 */
	public function handleProviderCallback($service)
	{
		$userSocial = Socialite::driver($service)->user();

		$authUser = $this->findOrCreateUser($userSocial,$service);
		
		\Auth::login($authUser, true);
        return redirect()->action('HomeController@home');
    }
    
    public function findOrCreateUser($user,$service)
    {
        if (\App\User::where('service_id', '=', $user->id)->exists())
        {
            return \App\User::where('service_id', $user->id)->first();
        }
        else
        {
        	$userTable 				    = new \App\User;
        	$userTable->name	        = $user->name;
        	$userTable->username	    = $user->name;
        	$userTable->email		    = $user->email;
        	$userTable->service		    = $service;
        	$userTable->service_id	    = $user->id;
        	$userTable->profile_image   = $user->avatar;
        	$userTable->password	    = '';
        	$userTable->save();
        	$userTable->id;
	        return \App\User::where('id',$userTable->id)->first();
        }
    }
}