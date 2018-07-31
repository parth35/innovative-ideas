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
     * This function is use for view gallery list page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.gallery.list'
     */
    function list()
    {
        $title = 'Gallery';
        return view('admin.modules.gallery.list',['title' => $title]);
    }
}
