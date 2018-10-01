<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use DialogFlow\Client;

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
		/* Start: Default photo list */
		$query = \App\Photo::approved()->orderBy('created_at','desc')->with('tags');
		/* End: Default photo list */
		
		/* Start: Photo list after tag filter */
		if(isset($input['tags']) && !empty($input['tags']))
		{
			$tag_link = \App\PhotosTag::select('photo_id')->where('tag_id',$input['tags'])->get()->toArray();
			$photo_arr = array();
			foreach($tag_link as $link)
			{
				$photo_arr[] = $link['photo_id'];
			}
			$query->whereIn('id',$photo_arr);
		}
		/* End: Photo list after tag filter */

		/* Start: Photo list after place filter */
		if(isset($input['place']) && !empty($input['place'])){
			$query->where('place_name',$input['place']);
		}
		/* End: Photo list after place filter */

		/* Start: Photo list pagination */
		$photos = $query->paginate(30);
		/* End: Photo list pagination */
		
		/* Load page when ajax call */
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
			$tags = \App\Tag::where('status','active')->get();
			return view('send_photo',compact('tags'));
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

	/**
	 * This function is used for submit photos from front side
	 *
	 * @param request $r
	 * @author Parth
	 * @version 1.0.0
	 * @return void
	 */
	public function photos_form(request $r)
	{
		$input = $r->all();

		$validatedData = $r->validate([
			'place_name'    => 'required|min:2|max:150',
			'address'       => 'required|min:2|max:300',
			'photos'        => 'required'
		]);

		if(isset($input['tags']) && !empty($input['tags']) && count($input['tags']) > 0)
		{
			foreach($input['tags'] as $tags)
			{
				$tag = \App\Tag::firstOrCreate(array('name' => $tags));
				$tag->name = $tags;
				$tag->save();
			}
		}

		$message = 'Photos added successfully.';

		foreach($r->file('photos') as $photos)
		{
			$place_name = str_replace(' ','_',strtolower($input['place_name']));
			$input['imagename'] = $place_name.'.'.time().'.'.$photos->getClientOriginalName();
			$destinationPath = base_path().'/public/gallery/';
			$photos->move($destinationPath, $input['imagename']);

			$photo = new \App\Photo;
			$photo->user_id = \Auth::user()->id;
			$photo->place_name = $input['place_name'];
			$photo->address = $input['address'];
			$photo->note = (isset($input['note']))?$input['note']:'';
			$photo->photos = $input['imagename'];
			$photo->approve = 'no';
			$photo->save();

			if(isset($input['tags']) && !empty($input['tags']) && count($input['tags']) > 0)
			{
				$delete_photo_link = \App\PhotosTag::where('photo_id',$photo->id)->delete();
				foreach($input['tags'] as $tags)
				{
					$tag = \App\Tag::where('name',$tags)->first();
					$tag_link = new \App\PhotosTag;
					$tag_link->photo_id = $photo->id;
					$tag_link->tag_id = $tag->id;
					$tag_link->save();
				}
			}
		}
		return redirect()->back()->with('success', $message);
	}

	/*
	public function chatbot(request $r)
	{
		$input = $r->all();
		try {
			$client = new Client('e47e67aaf10243c78086c8ccff14ae04');
		
			$query = $client->get('query', [
				'query' => 'hi',
				'sessionId' => time()
			]);
		
			$response = json_decode((string) $query->getBody(), true);
		} catch (\Exception $error) {
			echo $error->getMessage();
		}
		echo '<pre>'; print_r($response); exit;
	}
	*/
}