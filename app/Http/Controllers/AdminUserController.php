<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
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
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.users.edit'
     */
    public function saveuser(request $r)
    {
        $input = $r->all();
        $validatedData = $r->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email',
            'username'      => 'required',
            'password'      => 'required',
            'profile_image' => ($r->file('profile_image'))?'mimes:jpeg,png,jpg,gif,svg|max:2048':'',
        ]);

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
            $user = \App\User::where('id',$input['id'])->first();
        }
        else{
            $user = new \App\User;
        }
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        if(isset($input['imagename']) && !empty($input['imagename']))
        {
            $user->profile_image = $input['imagename'];
        }
        $user->status = 'active';
        $user->save();
        return redirect('/admin/users');
    }
}