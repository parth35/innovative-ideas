<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;

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
		if(\App\Photo::approved()->where('show_in_slider','yes')->count()>=$count)
		{
			$photos = \App\Photo::approved()->where('show_in_slider','yes')->get()->random($count);
		}
		else{
			$photos = '';
		}
		if(\App\Photo::approved()->where('show_in_slider','yes')->count()>0)
		{
			$section_back_image = \App\Photo::approved()->where('show_in_slider','yes')->inRandomOrder()->first();
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
	public function photos(request $r)
	{
		$input = $r->all();
		$query = \App\Photo::approved()->orderBy('created_at','desc');
		
		/* Start: Check for filters */
		if(isset($input['place']) && !empty($input['place']))
		{
			$query->where('place_name',$input['place']);
		}
		if(isset($input['tags']) && !empty($input['tags']))
		{
			// $query->where('tags',$input['tags']);
		}
		/* End: Check for filters */
		$photos = $query->paginate(30);
		
		if ($r->ajax()) {
			return view('load_photos', ['photos' => $photos])->render();
		}
		return view('photos', compact('photos'));
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
		if(Auth::check())
		{
			return view('send_photo');
		}
		else
		{
			session()->flash('warning', 'You have to login first.');
			return redirect('log_in');
		}
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
		if(\App\Photo::approved()->where('show_in_slider','yes')->count()>0)
		{
			$section_back_image = \App\Photo::approved()->where('show_in_slider','yes')->inRandomOrder()->first();
		}
		else{
			$section_back_image = '';
		}
		return view('log_in',['title' => $title, 'section_back_image' => $section_back_image]);
	}
	
	/**
	 * This function is used for socialite login.
	 *
	 * @param $service
	 * @author Parth
	 * @version 1.0.0
	 */
	public function socialLogin($service)
	{
		return Socialite::driver($service)->redirect();
	}

	/**
	 * This function is used for obtain the user information from Social Logged in.
	 *
	 * @author Parth
	 * @param $service
	 * @version 1.0.0
	 */
	public function handleProviderCallback($service)
	{
		$userSocial = Socialite::driver($service)->user();

		$authUser = $this->findOrCreateUser($userSocial,$service);
		
		\Auth::login($authUser, true);
		return redirect()->action('HomeController@home');
	}
	
	/**
	 * This function is used for add new user or check already exist.
	 *
	 * @author Parth
	 * @param $service
	 * @param $user
	 * @version 1.0.0
	 */
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
			$userTable->profile_image   = $user->avatar_original;
			$userTable->password	    = '';
			$userTable->save();
			$userTable->id;
			return \App\User::where('id',$userTable->id)->first();
		}
	}
	
	/**
	 * This function is used for log out.
	 *
	 * @author Parth
	 * @version 1.0.0
	 */
	public function log_out()
	{
		\Auth::logout();
		return redirect()->back();
	}

	/**
	 * This function is used for get tags for photos serach
	 *
	 * @param request $r
	 * @author Parth
	 * @version 1.0.0
	 * @return void
	 */
	public function get_tags(request $r)
	{
		$input = $r->all();
		$tags = \App\Tag::select('id','name')->where('name','like','%'.$input['tags'].'%')->get()->toArray();
		$all_tags = array();
		if(count($tags) > 0)
		{
			foreach($tags as $tag)
			{
				$all_tags[] = array('value' => $tag['name'], 'data' => $tag['id']);
			}
		}
		print_r(json_encode($all_tags));
	}

	/**
	 * This function is used for get places for photos serach
	 *
	 * @param request $r
	 * @author Parth
	 * @version 1.0.0
	 * @return void
	 */
	public function get_places(request $r)
	{
		$input = $r->all();

		$places = \App\Photo::select("place_name")->approved()->where('place_name','like','%'.$input['places'].'%')->groupBy('photos.place_name')->get()->toArray();

		$all_place = array();
		if(count($places) > 0)
		{
			foreach($places as $place)
			{
				$all_place[] = array('value' => $place['place_name']);
			}
		}
		print_r(json_encode($all_place));
	}
}