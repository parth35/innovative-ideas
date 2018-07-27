<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminTagsController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * This function is used for listing all tags.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.tags.list'
     */
    public function tags()
    {
        $title = 'Tags';
        $tags = \App\Tag::get();
        return view('admin.modules.tags.list',['title' => $title, 'tags' => $tags]);
    }

    /**
     * This function is used for view add tag page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.tags.edit'
     */
    public function add()
    {
        $title = 'Add Tags';
        return view('admin.modules.tags.edit',['title' => $title]);
    }

    /**
     * This function is used for view edit tag page.
     *
     * @param int $id
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.tags.edit'
     */
    public function edit($id)
    {
        $title = 'Edit Tags';
        $tag = \App\Tag::where('id',$id)->first();
        return view('admin.modules.tags.edit',['title' => $title, 'id' => $id, 'tag' => $tag]);
    }

    /**
     * This function is used for save tag to database.
     *
     * @param Request $r
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.tags.edit'
     */
    public function savetag(Request $r)
    {
        $input = $r->all();
        if(isset($input['id']) && !empty($input['id']))
        {
            $validatedData = $r->validate([
                'name'      	=> 'required|max:100|unique:tags,id,'.$input["id"]
            ]);
        }
        else{
            $validatedData = $r->validate([
                'name'      	=> 'required|max:100|unique:tags',
            ]);
        }

        if(isset($input['id']) && !empty($input['id']))
        {
            $message = 'Tag updated successfully.';
            $tag = \App\Tag::where('id',$input['id'])->first();
        }
        else{
            $message = 'Tag added successfully.';
            $tag = new \App\Tag;
        }
        $tag->name = $input['name'];
        $tag->status = 'active';
        $tag->save();
        return redirect('/admin/tags')->with('success', $message);;
    }

    /**
	 * This function is used for change the status of data.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/tags'
	 */
	public function status($id)
	{
		$tags_status = \App\Tag::where('id',$id)->first();
		if($tags_status->status == 'active')
		{
			$tags_status->status = 'inactive';
			$tags_status->save();
		}
		else
		{
			$tags_status->status = 'active';
			$tags_status->save();
		}
		$message = 'Tag status changed successfully.';
		return redirect('/admin/tags')->with('success', $message);
	}

	/**
	 * This function is used for delete the data from database.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/tags'
	 */
	public function delete($id)
	{
		$tag_delete = \App\Tag::where('id',$id)->first();
		$tag_delete->delete();

		$message = 'Tag deleted successfully.';
		return redirect('/admin/tags')->with('success', $message);
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
		foreach($input['datachecked'] as $tag)
		{
			$tag_status = \App\Tag::where('id',$tag)->first();
			$tag_status->status = 'active';
			$tag_status->save();
        }
        session()->flash('success', 'Tag(s) status changed successfully.');
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
		foreach($input['datachecked'] as $tag)
		{
			$tag_status = \App\Tag::where('id',$tag)->first();
			$tag_status->status = 'inactive';
			$tag_status->save();
        }
        session()->flash('success', 'Tag(s) status changed successfully.');
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
		foreach($input['datachecked'] as $tag)
		{
			$tag_status = \App\Tag::where('id',$tag)->first();
			$tag_status->delete();
        }
        session()->flash('success', 'Tag(s) deleted successfully.');
		echo 'success';
	}
}
