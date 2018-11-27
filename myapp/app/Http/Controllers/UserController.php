<?php

/**
 * Description of UserController
 *
 * @author Team yugioh
 */

namespace App\Http\Controllers;

use App\Http\Models\locations;
use App\Http\Models\User;
use App\Http\Models\Category;
use App\Http\Models\Event;
use Illuminate\Http\Request;
use Session;
use Validator;

class UserController extends Controller
{

	/**
	 * shows the view with all the users in the database
	 * @return type view & users
	 */
	public function index()
	{
		return view('user/viewUsers', ['users' => User::get()]);
	}

	public function viewUser($id)
	{
		$user = new user();
		$user = $user->find($id);

		return view('user/editUser', ['user' => $user, 'locations' => locations::all()]);
	}

	/**
	 * makes a user an organisator
	 * @param Request $request
	 * @param type $userID
	 */
	public function updateUser(Request $request)
	{
		$validator = Validator::make($request->all(), [
			  'firstname' => 'required|max:40',
			  'lastname' => 'required|max:40',
			  'student_number' => 'required|integer',
			  'location' => 'required|integer',
			  'email' => 'required|email',
			  'activated' => 'required|max:40',
			  'role' => 'required|max:40',
			  'id' => 'required|integer'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator);
		} else {

			$user = new User();
			$user = $user->find($request->id);

			if ($user->role == 'teacher' && $request->role != 'teacher') {
				if (Count($user->where('role', 'teacher')->get()) == 1) {

					return back()->withErrors(['message' => 'You cannot edit "' . $request->firstname . ' ' . $request->lastname . '" role because it is the last user with the teacher role']);
				}
			}

			if ($user->role === "teacher" && $request->input('status') == 'ban') {
				return back()->withErrors(['message' => 'You can not ban another teacher']);
			} else {
				if ($request->input('status') == 'ban') {
					$user->events()->detach();	
					$events = Event::where('user_id', $user->id)->get();
					foreach ($events as $event) {
						$event->categories()->detach();
						$event->users()->detach();
						$event->delete();
					}
				}
			}

			$user->editUser($request->all());

			return back()->with('message', 'Succesfully changed user data of " ' . $user->firstname . ' ' . $user->lastname . ' "');
		}
	}

}
