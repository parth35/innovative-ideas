<?php

function user_profile_image_url($image)
{
	if(isset($image) && !empty($image) && file_exists( base_path().'/public/image/user_profile_image/'.$image))
	{
		return base_url('/image/user_profile_image/'.$image);
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

?>