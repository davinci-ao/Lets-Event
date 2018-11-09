<?php

/**
 * Description of UserController
 *
 * @author Team yugioh
 */

namespace App\Http\Controllers;

use App\Http\Models\locations;
use App\Http\Models\User;
use App\Http\Models\participations;
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
        $users = User::get();
        return view('viewUsers', ['users' => $users]);
    }

    public function viewUser($userID)
    {
        $user = User::where('id', $userID)->first();

        $locations = new locations();
        $locations = $locations::all();

        return view('editUser', ['user' => $user, 'locations' => $locations]);
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
            'studentnr' => 'required|integer',
            'location' => 'required|integer',
            'email' => 'required|email',
            'activated' => 'required|max:40',
            'role' => 'required|max:40',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->with('message', implode('<br>', $validator->errors()->all()));
        } else {

			$user = new User();
			$user = $user->find($request->id);

			if ($user->role == 'teacher' && $request->role != 'teacher') {
				if (Count($user->where('role', 'teacher')->get()) == 1) {

                    return back()->with('message', 'Error u cannot edit "' . $request->firstname . ' ' . $request->lastname . '" role because it is the last user with the teacher role');
                }
            }

            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->student_nr = $request->studentnr;
            $user->education_location_id = $request->location;
            $user->email = $request->email;
            $user->activated = $request->activated;
            $user->role = $request->role;
            $user->save();

            Session::flash('positive', true);
            return back()->with('message', 'Succesfully changed User data of " ' . $user->firstname . ' ' . $user->lastname . ' "');
        }
    }

    public function userStatus($userId)
    {
        $user = User::where('id', $userId)->first();

        return view('userStatus', ['user' => $user]);
    }   

    public function saveUserStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('message', implode('<br>', $validator->errors()->all()));
        } else {

            $user = new User();
            $user = $user->find($request->id);

            $user->status = $request->status;

            if ($user->role != 'teacher') {
                $user->save();
                if ($user->status == 'ban') {       
                    participations::where('user_id', $user->id)->delete();   
                    Event::where('user_id', $user->id)->delete();  
                } 
            } 
        }

            Session::flash('positive', true);
            return back()->with('message', 'Succesfully changed User data of " ' . $user->firstname . ' ' . $user->lastname . ' "');
    }

}
