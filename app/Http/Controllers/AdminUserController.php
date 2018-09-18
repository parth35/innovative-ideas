<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * This function is used for listing all users.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.users.list'
     */
    public function users()
    {
        $title = 'Users';
        $users = \App\User::get();
        return view('admin.modules.users.list',['title' => $title, 'users' => $users]);
    }

    /**
     * This function is used for view add user page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.users.edit'
     */
    public function add()
    {
        $title = 'Add Users';
        return view('admin.modules.users.edit',['title' => $title]);
    }

    /**
     * This function is used for view edit user page.
     *
     * @param int $id
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.users.edit'
     */
    public function edit($id)
    {
        $title = 'Edit Users';
        $user = \App\User::where('id',$id)->first();
        return view('admin.modules.users.edit',['title' => $title, 'id' => $id, 'user' => $user]);
    }

    /**
     * This function is used for save user to database.
     *
     * @param Request $r
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.users.edit'
     */
    public function saveuser(Request $r)
    {
        $input = $r->all();
        if(isset($input['id']) && !empty($input['id']))
        {
            $validatedData = $r->validate([
                'name'          => 'required|max:100',
                'email'         => 'required|max:150|email|unique:users,id,'.$input['id'],
                'username'      => 'required|max:100',
                'password'      => 'required',
                'profile_image' => ($r->file('profile_image'))?'mimes:jpeg,png,jpg,gif,svg|max:2048':'',
            ]);
        }
        else
        {
            $validatedData = $r->validate([
                'name'          => 'required|max:100',
                'email'         => 'required|max:150|email|unique:users',
                'username'      => 'required|max:100',
                'password'      => 'required',
                'profile_image' => ($r->file('profile_image'))?'mimes:jpeg,png,jpg,gif,svg|max:2048':'',
            ]);
        }

        if($r->file('profile_image'))
        {
            $image = $r->file('profile_image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = base_path().'/public/image/user_profile_image/';
            $image->move($destinationPath, $input['imagename']);
        }
        elseif(isset($input['profileimage']) && !empty($input['profileimage']))
        {
            $input['imagename'] = $input['profileimage'];
        }

        if(isset($input['id']) && !empty($input['id']))
        {
            $message = 'User updated successfully.';
            $user = \App\User::where('id',$input['id'])->first();
        }
        else{
            $message = 'User added successfully.';
            $user = new \App\User;
        }
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        if(isset($input['imagename']) && !empty($input['imagename']))
        {
            $user->profile_image = $input['imagename'];
        }
        $user->status = 'active';
        $user->save();
        return redirect('/admin/users')->with('success', $message);;
    }

    /**
	 * This function is used for change the status of data.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/users'
	 */
	public function status($id)
	{
		$users_status = \App\User::where('id',$id)->first();
		if($users_status->status == 'active')
		{
			$users_status->status = 'inactive';
			$users_status->save();
		}
		else
		{
			$users_status->status = 'active';
			$users_status->save();
		}
		$message = 'User status changed successfully.';
		return redirect('/admin/users')->with('success', $message);
	}

	/**
	 * This function is used for delete the data from database.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/users'
	 */
	public function delete($id)
	{
		$user_delete = \App\User::where('id',$id)->first();
		if(\File::exists(base_path().'/public/image/user_profile_image/'.$user_delete->profile_image)) {
			\File::delete(base_path().'/public/image/user_profile_image/'.$user_delete->profile_image);
		}
		$user_delete->delete();

		$message = 'User deleted successfully.';
		return redirect('/admin/users')->with('success', $message);
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
		foreach($input['datachecked'] as $user)
		{
			$user_status = \App\User::where('id',$user)->first();
			$user_status->status = 'active';
			$user_status->save();
        }
        session()->flash('success', 'User(s) status changed successfully.');
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
		foreach($input['datachecked'] as $user)
		{
			$user_status = \App\User::where('id',$user)->first();
			$user_status->status = 'inactive';
			$user_status->save();
        }
        session()->flash('success', 'User(s) status changed successfully.');
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
		foreach($input['datachecked'] as $user)
		{
            $user_status = \App\User::where('id',$user)->first();
            
            if(\File::exists(base_path().'/public/image/user_profile_image/'.$user_status->profile_image)) {
                \File::delete(base_path().'/public/image/user_profile_image/'.$user_status->profile_image);
            }

			$user_status->delete();
        }
        session()->flash('success', 'User(s) deleted successfully.');
		echo 'success';
	}
}
