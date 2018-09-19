<?php

function user_profile_image_url($image)
{
	if(isset($image) && !empty($image))
	{
		return $image;
	}
	else
	{
		return base_url('/image/default.jpg');
	}
}

function gallery_photo_url($image)
{
	if(isset($image) && !empty($image) && file_exists( base_path().'/public/gallery/'.$image))
	{
		return base_url('gallery/'.$image);
	}
	else
	{
		return base_url('/image/default.jpg');
	}
}

function change_status($status,$url)
{
	if($status == 'active')
	{
		return "<a class='edt-dlt' href='".$url."' style='color:green'><b>Active</b></a>";
	}
	else if($status == 'inactive')
	{
		return "<a href='".$url."' style='color:red'><b>Inactive</b></a>";
	}
}

function photo_approve($status,$url)
{
	if($status == 'yes')
	{
		return "<a class='edt-dlt' href='".$url."' style='color:green'><b>Approved</b></a>";
	}
	else if($status == 'no')
	{
		return "<a href='".$url."' style='color:red'><b>Not Approved</b></a>";
	}
}

function check_segment($order,$segment)
{
	return (Request::segment($order) == $segment) ? true : false;
}

?>