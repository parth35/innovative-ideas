<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminGalleryController extends Controller
{
    
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * This function is use for view photos list page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.gallery.list'
     */
    function list()
    {
        $title = 'Photos';
        $photos = \App\Photo::get();
        return view('admin.modules.gallery.list',['title' => $title, 'photos' => $photos]);
    }

    /**
     * This function is used for view add photos page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.gallery.edit'
     */
    public function add()
    {
        $title = 'Add Photos';
        $users = \App\User::get();
        $tags = \App\Tag::get();
        return view('admin.modules.gallery.edit',['title' => $title, 'users' => $users, 'tags' => $tags]);
    }

    /**
     * This function is used for view edit photo page.
     *
     * @param int $id
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.gallery.edit'
     */
    public function edit($id)
    {
        $title = 'Edit Photos';
        $users = \App\User::get();
        $tags = \App\Tag::get();
        $photo = \App\Photo::where('id',$id)->first();
        return view('admin.modules.gallery.edit',['title' => $title, 'id' => $id, 'photo' => $photo, 'tags' => $tags, 'users' => $users]);
    }

    /**
     * This function is used for save user to database.
     *
     * @param Request $r
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.users.edit'
     */
    public function savephotos(Request $r)
    {
        $input = $r->all();
        if($r->hasfile('photos')){
            $validatedData = $r->validate([
                'user_id'       => 'required',
                'place_name'    => 'required|min:2|max:150',
                'address'       => 'required|min:2|max:300',
                'photos'        => 'required'
            ]);
        }
        else{
            $validatedData = $r->validate([
                'user_id'       => 'required',
                'place_name'    => 'required|min:2|max:150',
                'address'       => 'required|min:2|max:300',
                'edit_photo'    => 'required'
            ]);
        }

        if(isset($input['tags']))
        {
            foreach($input['tags'] as $tags)
            {
                $tag = \App\Tag::firstOrCreate(array('name' => $tags));
                $tag->name = $tags;
                $tag->save();
            }
        }

        if($r->hasfile('photos'))
        {
            if(isset($input['id']) && !empty($input['id'])){
                $message = 'Photos updated successfully.';
            }
            else{
                $message = 'Photos added successfully.';
            }

            foreach($r->file('photos') as $photos)
            {
                $place_name = str_replace(' ','_',strtolower($input['place_name']));
                $input['imagename'] = $place_name.'.'.time().'.'.$photos->getClientOriginalName();
                $destinationPath = base_path().'/public/gallery/';
                $photos->move($destinationPath, $input['imagename']);

                if(isset($input['id']) && !empty($input['id'])){
                    $photo = \App\Photo::where('id',$input['id'])->first();
                    if(\File::exists(base_path().'/public/gallery/'.$photo->photos)) {
                        \File::delete(base_path().'/public/gallery/'.$photo->photos);
                    }
                }
                else{
                    $photo = new \App\Photo;
                }
                $photo->user_id = $input['user_id'];
                $photo->tags = (isset($input['tags']))?serialize($input['tags']):'';
                $photo->place_name = $input['place_name'];
                $photo->address = $input['address'];
                $photo->note = (isset($input['note']))?$input['note']:'';
                $photo->photos = $input['imagename'];
                $photo->approve = 'no';
                $photo->save();
            }
        }
        elseif(isset($input['edit_photo']) && !empty($input['edit_photo']))
        {
            $input['imagename'] = $input['edit_photo'];
            $message = 'Photos updated successfully.';
            $photo = \App\Photo::where('id',$input['id'])->first();
            $photo->user_id = $input['user_id'];
            $photo->tags = (isset($input['tags']))?serialize($input['tags']):'';
            $photo->place_name = $input['place_name'];
            $photo->address = $input['address'];
            $photo->note = (isset($input['note']))?$input['note']:'';
            $photo->photos = $input['imagename'];
            $photo->approve = 'no';
            $photo->save();
        }

        return redirect('/admin/photos')->with('success', $message);
    }

    /**
	 * This function is used for change the status of data.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/photos'
	 */
	public function status($id)
	{
		$photo_status = \App\Photo::where('id',$id)->first();
		if($photo_status->approve == 'yes')
		{
			$photo_status->approve = 'no';
			$photo_status->save();
		}
		else
		{
			$photo_status->approve = 'yes';
			$photo_status->save();
		}
		$message = 'Photo status changed successfully.';
		return redirect('/admin/photos')->with('success', $message);
    }

    /**
	 * This function is used for change the status of photo is show in slider in front home page or not.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/photos'
	 */
	public function show_in_slider($id)
	{
		$photo_status = \App\Photo::where('id',$id)->first();
		if($photo_status->show_in_slider == 'yes')
		{
			$photo_status->show_in_slider = 'no';
			$photo_status->save();
		}
		else
		{
			$photo_status->show_in_slider = 'yes';
			$photo_status->save();
		}
		$message = 'Photo status changed successfully.';
		return redirect('/admin/photos')->with('success', $message);
    }
    
    /**
	 * This function is used for delete the data from database.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/photos'
	 */
	public function delete($id)
	{
		$photo_delete = \App\Photo::where('id',$id)->first();
		if(\File::exists(base_path().'/public/gallery/'.$photo_delete->photos)) {
			\File::delete(base_path().'/public/gallery/'.$photo_delete->photos);
		}
		$photo_delete->delete();

		$message = 'Photo deleted successfully.';
		return redirect('/admin/photos')->with('success', $message);
    }
    
    /**
	 * This function is used for active all inactive selected data.
     * 
	 * @param Request $r
	 * @version 1.0.0
	 * @author Parth
	 * @return string 'success'
	 */
	public function active_all(Request $r)
	{
		$input = $r->all();
		foreach($input['datachecked'] as $photo)
		{
			$photo_status = \App\Photo::where('id',$photo)->first();
			$photo_status->approve = 'yes';
			$photo_status->save();
        }
        session()->flash('success', 'Photo(s) status changed successfully.');
		echo 'success';
	}

	/**
	 * This function is used for inactive-all active selected data.
     * 
	 * @param Request $r
	 * @version 1.0.0
	 * @author Parth
	 * @return string 'success'
	 */
	public function inactive_all(Request $r)
	{
		$input = $r->all();
		foreach($input['datachecked'] as $photo)
		{
			$photo_status = \App\Photo::where('id',$photo)->first();
			$photo_status->approve = 'no';
			$photo_status->save();
        }
        session()->flash('success', 'Photo(s) status changed successfully.');
		echo 'success';
	}

	/**
	 * This function is used for delete-all selected data.
     * 
	 * @param Request $r
	 * @version 1.0.0
	 * @author Parth
	 * @return string 'success'
	 */
	public function delete_all(Request $r)
	{
		$input = $r->all();
		foreach($input['datachecked'] as $photo)
		{
            $photo_status = \App\Photo::where('id',$photo)->first();
            
            if(\File::exists(base_path().'/public/gallery/'.$photo_status->photos)) {
                \File::delete(base_path().'/public/gallery/'.$photo_status->photos);
            }

			$photo_status->delete();
        }
        session()->flash('success', 'Photo(s) deleted successfully.');
		echo 'success';
	}
}
