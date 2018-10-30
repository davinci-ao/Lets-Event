<?php

/**
 * Description of UserController
 *
 * @author Team yugioh
 */

namespace App\Http\Controllers;
use Auth;

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
		$user = Auth()->user();

		if ($user->status == 'empty') {
			session()->flash('default', 'Welcome in Letsevents!');
		}elseif ($user->status == 'warning') {
			session()->flash('warning', 'Watch out you have a warning, the next step is a ban!!!' );
		}elseif ($user->status == 'ban') {
			session()->flash('danger', 'You have a ban, contact the admin for more info....');
		}

		return view('home', ['user' => $user]);
	}

}
