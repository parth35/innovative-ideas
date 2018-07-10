<?php

//================ START: URL SECTION ============
function base_url($path='http://localhost:8000')
{
	return url()->asset($path);
}

function admin_url($path)
{
	return url('/admin'.$path);
}

function css_url($path)
{
	return url()->asset('/css'.$path);
}

function js_url($path)
{
	return url()->asset('/js'.$path);
}
//================ END: URL SECTION ============

?>