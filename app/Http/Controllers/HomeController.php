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
        $count = 3;
        if(\App\Photo::where('approve','yes')->where('show_in_slider','yes')->count()>=$count)
        {
            $photos = \App\Photo::where('approve','yes')->where('show_in_slider','yes')->get()->random($count);
        }
        else{
            $photos = '';
        }
        return view('home',['photos' => $photos, 'title' => $title]);
    }
}