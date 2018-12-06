<?php

/**
 * Description of UserController
 *
 * @author Team yugioh
 */

namespace App\Http\Controllers;

use Auth;
use App\Http\Models\participations;
use App\Http\Models\locations;
use App\Http\Models\Event;
use Session;

class HomeController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = Auth::user();
		$location = Locations::where('id', $user->education_location_id)->first();
		$events = $user->events()->get();
		

		session()->flash('danger', 'You have a ban and been written out by all events. We also have deleted the events where you are the organisator of, contact the admin for more info.');
		if ($user->status == 'warning') {
			Session::flash('alert-class', 'alert-warning');
			$message = 'Watch out you have a warning, the next step is a ban!';
		} elseif ($user->status == 'ban') {
			Session::flash('alert-class', 'alert-danger');
			$message = 'You have a ban and been written out by all events. We also have deleted the events where you are the organisator of, contact the admin for more info.';
		} else {
			$message = 'Welcome to Lets Event!';
		}


		return view('home', ['user' => $user, 'location' => $location, 'events' => $events])->with('message', $message);
	}

}
