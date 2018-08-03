<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * This function is used for view home page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view ''
     */
    public function Home()
    {
        $title = 'Home';
        $photos = \App\Photo::where('approve','yes')->get();
        return view('home',['photos' => $photos, 'title' => $title]);
    }
}