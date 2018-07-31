<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCitiesController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    /**
     * This function is used for view cities listing page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.cities.list'
     */
    public function cities()
    {
        $title = 'Cities';
        $countries = \App\Country::get();
        return view('admin.modules.cities.list',['title' => $title, 'countries' => $countries]);
    }

    /**
     * This function is used for get states as per country.
     *
     * @author Parth
     * @version 1.0.0
     */
    public function get_data(Request $r)
    {
        $input = $r->all();
        $states = \App\State::where('country_id',$input['country_id'])->get()->toArray();
        $state_arr = array();
        foreach($states as $state)
        {
            array_push($state_arr,array( 'id'=> $state['id'], 'name'=> $state['name'], 'status'=> $state['status']));
        }
        print_r(json_encode($state_arr));
    }

    /**
     * This function is used for get cities as per state.
     *
     * @author Parth
     * @version 1.0.0
     */
    public function get_city_data(Request $r)
    {
        $input = $r->all();
        $cities = \App\City::where('state_id',$input['state_id'])->get()->toArray();
        $cities_arr = array();
        foreach($cities as $city)
        {
            $cities_arr[] = ["<input type='checkbox' name='cities' class='data_checkbox' id='".$city['id']."'/>", $city['name'], change_status($city['status'],base_url('/admin/cities/status/'.$city['id'])), "<a title='Edit' href='".base_url('/admin/cities/edit/'.$city['id'])."'><i class='fa fa-fw fa-edit'></i></a>&nbsp;&nbsp;<a title='Delete' href='".base_url('/admin/cities/delete/'.$city['id'])."'><i class='fa fa-fw fa-remove'></i></a>"];
        }
        print_r(json_encode($cities_arr));
    }

    /**
     * This function is used for view add city page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.cities.edit'
     */
    public function add()
    {
        $title = 'Add City';
        $countries = \App\Country::get();
        return view('admin.modules.cities.edit',['title' => $title, 'countries'=> $countries]);
    }

    /**
     * This function is used for view edit city page.
     *
     * @param int $id
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.cities.edit'
     */
    public function edit($id)
    {
        $title = 'Edit City';
        $city = \App\City::where('id',$id)->first();
        $country_id = \App\State::where('id',$city['state_id'])->first()->country_id;
        $countries = \App\Country::get();
        return view('admin.modules.cities.edit',['title' => $title, 'id' => $id, 'city' => $city, 'countries'=> $countries, 'country_id' => $country_id]);
    }

    /**
     * This function is used for save city to database.
     *
     * @param Request $r
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.cities.edit'
     */
    public function savecity(Request $r)
    {
        $input = $r->all();
        $validatedData = $r->validate([
            'state_id'      => 'required|integer',
            'name'      	=> 'required|max:150',
        ]);

        if(isset($input['id']) && !empty($input['id']))
        {
            $message = 'City updated successfully.';
            $city = \App\City::where('id',$input['id'])->first();
        }
        else{
            $message = 'City added successfully.';
            $city = new \App\City;
        }
        $city->state_id   = $input['state_id'];
        $city->name       = $input['name'];
        $city->status     = 'active';
        $city->save();
        return redirect('/admin/cities')->with('success', $message);;
    }

    /**
	 * This function is used for change the status of data.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/cities'
	 */
	public function status($id)
	{
		$cities_status = \App\City::where('id',$id)->first();
		if($cities_status->status == 'active')
		{
			$cities_status->status = 'inactive';
			$cities_status->save();
		}
		else
		{
			$cities_status->status = 'active';
			$cities_status->save();
		}
		$message = 'City status changed successfully.';
		return redirect('/admin/cities')->with('success', $message);
	}

	/**
	 * This function is used for delete the data from database.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/cities'
	 */
	public function delete($id)
	{
		$city_delete = \App\City::where('id',$id)->first();
		$city_delete->delete();

		$message = 'City deleted successfully.';
		return redirect('/admin/cities')->with('success', $message);
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
		foreach($input['datachecked'] as $city)
		{
			$city_status = \App\City::where('id',$city)->first();
			$city_status->status = 'active';
			$city_status->save();
        }
        session()->flash('success', 'City(s) status changed successfully.');
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
		foreach($input['datachecked'] as $city)
		{
			$city_status = \App\City::where('id',$city)->first();
			$city_status->status = 'inactive';
			$city_status->save();
        }
        session()->flash('success', 'City(s) status changed successfully.');
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
		foreach($input['datachecked'] as $city)
		{
			$city_status = \App\City::where('id',$city)->first();
			$city_status->delete();
        }
        session()->flash('success', 'City(s) deleted successfully.');
		echo 'success';
	}
}
