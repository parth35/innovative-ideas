<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * This function is used for get user detail
     *
     * @author Parth
	 * @version 1.0.0
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeApproved($query)
    {
        return $query->where('approve','yes');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','photos_tags','photo_id','tag_id');
    }
}
