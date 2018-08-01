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
        return view('admin.modules.gallery.list',['title' => $title]);
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
}
