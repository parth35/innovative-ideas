<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminStatesController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    /**
     * This function is used for view states listing page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.states.list'
     */
    public function states()
    {
        $title = 'States';
        $countries = \App\Country::get();
        return view('admin.modules.states.list',['title' => $title, 'countries' => $countries]);
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
        foreach($states as $state)
        {
            $state_arr[] = [  "<input type='checkbox' name='states' class='data_checkbox' id='".$state['id']."'/>", $state['name'], change_status($state['status'],base_url('/admin/states/status/'.$state['id'])), "<a title='Edit' href='".base_url('/admin/states/edit/'.$state['id'])."'><i class='fa fa-fw fa-edit'></i></a>&nbsp;&nbsp;<a title='Delete' href='".base_url('/admin/states/delete/'.$state['id'])."'><i class='fa fa-fw fa-remove'></i></a>"];
        }
        print_r(json_encode($state_arr));
    }

    /**
     * This function is used for view add state page.
     *
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.states.edit'
     */
    public function add()
    {
        $title = 'Add State';
        $countries = \App\Country::get();
        return view('admin.modules.states.edit',['title' => $title, 'countries'=> $countries]);
    }

    /**
     * This function is used for view edit state page.
     *
     * @param int $id
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.states.edit'
     */
    public function edit($id)
    {
        $title = 'Edit State';
        $state = \App\State::where('id',$id)->first();
        $countries = \App\Country::get();
        return view('admin.modules.states.edit',['title' => $title, 'id' => $id, 'state' => $state, 'countries'=> $countries]);
    }

    /**
     * This function is used for save state to database.
     *
     * @param Request $r
     * @author Parth
     * @version 1.0.0
     * @return view 'admin.modules.states.edit'
     */
    public function savestate(Request $r)
    {
        $input = $r->all();
        $validatedData = $r->validate([
            'country_id'    => 'required|integer',
            'name'      	=> 'required|max:150',
        ]);

        if(isset($input['id']) && !empty($input['id']))
        {
            $message = 'State updated successfully.';
            $state = \App\State::where('id',$input['id'])->first();
        }
        else{
            $message = 'State added successfully.';
            $state = new \App\State;
        }
        $state->country_id = $input['country_id'];
        $state->name       = $input['name'];
        $state->status     = 'active';
        $state->save();
        return redirect('/admin/states')->with('success', $message);;
    }

    /**
	 * This function is used for change the status of data.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/states'
	 */
	public function status($id)
	{
		$states_status = \App\State::where('id',$id)->first();
		if($states_status->status == 'active')
		{
			$states_status->status = 'inactive';
			$states_status->save();
		}
		else
		{
			$states_status->status = 'active';
			$states_status->save();
		}
		$message = 'State status changed successfully.';
		return redirect('/admin/states')->with('success', $message);
	}

	/**
	 * This function is used for delete the data from database.
     * 
	 * @param int $id
	 * @version 1.0.0
	 * @author Parth
	 * @return Redirect '/admin/states'
	 */
	public function delete($id)
	{
		$state_delete = \App\State::where('id',$id)->first();
		$state_delete->delete();

		$message = 'State deleted successfully.';
		return redirect('/admin/states')->with('success', $message);
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
		foreach($input['datachecked'] as $state)
		{
			$state_status = \App\State::where('id',$state)->first();
			$state_status->status = 'active';
			$state_status->save();
        }
        session()->flash('success', 'State(s) status changed successfully.');
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
		foreach($input['datachecked'] as $state)
		{
			$state_status = \App\State::where('id',$state)->first();
			$state_status->status = 'inactive';
			$state_status->save();
        }
        session()->flash('success', 'State(s) status changed successfully.');
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
		foreach($input['datachecked'] as $state)
		{
			$state_status = \App\State::where('id',$state)->first();
			$state_status->delete();
        }
        session()->flash('success', 'State(s) deleted successfully.');
		echo 'success';
	}
}
