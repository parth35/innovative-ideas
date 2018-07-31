<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCountriesController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * This function is used for listing all countries.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.countries.list'
     */
    public function countries()
    {
        $title = 'Countiries';
        $countries = \App\Country::get();
        return view('admin.modules.countries.list',['title' => $title, 'countries' => $countries]);
    }

    /**
     * This function is used for view add country page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.countries.edit'
     */
    public function add()
    {
        $title = 'Add Country';
        return view('admin.modules.countries.edit',['title' => $title]);
    }

    /**
     * This function is used for view edit country page.
     *
     * @param int $id
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.countries.edit'
     */
    public function edit($id)
    {
        $title = 'Edit Country';
        $country = \App\Country::where('id',$id)->first();
        return view('admin.modules.countries.edit',['title' => $title, 'id' => $id, 'country' => $country]);
    }

    /**
     * This function is used for save country to database.
     *
     * @param Request $r
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.countries.edit'
     */
    public function savecountry(Request $r)
    {
        $input = $r->all();
        if(isset($input['id']) && !empty($input['id']))
        {
            $validatedData = $r->validate([
                'name'      	=> 'required|max:150|unique:countries,id,'.$input["id"],
                'sortname'  	=> 'required|max:50',
                'phonecode'     => 'nullable|integer'
            ]);
        }
        else{
            $validatedData = $r->validate([
                'name'      	=> 'required|max:150|unique:countries',
                'sortname'  	=> 'required|max:50',
                'phonecode'     => 'nullable|integer'
            ]);
        }

        if(isset($input['id']) && !empty($input['id']))
        {
            $message = 'Country updated successfully.';
            $country = \App\Country::where('id',$input['id'])->first();
        }
        else{
            $message = 'Country added successfully.';
            $country = new \App\Country;
        }
        $country->name      = $input['name'];
        $country->sortname  = $input['sortname'];
        $country->phonecode = $input['phonecode'];
        $country->status    = 'active';
        $country->save();
        return redirect('/admin/countries')->with('success', $message);;
    }

    /**
	 * This function is used for change the status of data.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/countries'
	 */
	public function status($id)
	{
		$countries_status = \App\Country::where('id',$id)->first();
		if($countries_status->status == 'active')
		{
			$countries_status->status = 'inactive';
			$countries_status->save();
		}
		else
		{
			$countries_status->status = 'active';
			$countries_status->save();
		}
		$message = 'Country status changed successfully.';
		return redirect('/admin/countries')->with('success', $message);
	}

	/**
	 * This function is used for delete the data from database.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/countries'
	 */
	public function delete($id)
	{
		$country_delete = \App\Country::where('id',$id)->first();
		$country_delete->delete();

		$message = 'Country deleted successfully.';
		return redirect('/admin/countries')->with('success', $message);
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
		foreach($input['datachecked'] as $country)
		{
			$country_status = \App\Country::where('id',$country)->first();
			$country_status->status = 'active';
			$country_status->save();
        }
        session()->flash('success', 'Country(s) status changed successfully.');
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
		foreach($input['datachecked'] as $country)
		{
			$country_status = \App\Country::where('id',$country)->first();
			$country_status->status = 'inactive';
			$country_status->save();
        }
        session()->flash('success', 'Country(s) status changed successfully.');
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
		foreach($input['datachecked'] as $country)
		{
			$country_status = \App\Country::where('id',$country)->first();
			$country_status->delete();
        }
        session()->flash('success', 'Country(s) deleted successfully.');
		echo 'success';
	}
}
