<?php

namespace App\Http\Controllers\Auth;

use App\Http\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Mail\AcountConfirm;
use Mail;
use Session;

class RegisterController extends Controller
{
	/*
	  |--------------------------------------------------------------------------
	  | Register Controller
	  |--------------------------------------------------------------------------
	  |
	  | This controller handles the registration of new users as well as their
	  | validation and creation. By default this controller uses a trait to
	  | provide this functionality without requiring any additional code.
	  |
	 */

use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			  'student_number' => [
				'required',
				'string',
				'max:255',
				function($attribute, $value, $fail) {
					$user = User::where('student_nr', $value)->first();
					if ($user === null) {
						return $fail(Session::flash('message', 'No user found'));
					} else if ($user->activated == 'activated') {
						return $fail(Session::flash('message', 'This acount is already active'));
					}
				}
			  ]
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
		$token = md5(uniqid());
		$user = User::where('student_nr', $data['student_number'])->first();
		$user->token = $token;
		$user->email_send_at = date('Y-m-d');
		$user->save();
		Mail::to($user->email)->send(new AcountConfirm($token));

		return $user;
	}

	/**
	 * complete the registartion of the user.
	 * @param token string
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function completeRegistration($token)
	{
		$user = User::where('token', $token)->first();
		if ($user == null || $user->activated == 'activated') {
			if ($user == null) {
				Session::flash('message', 'An unexpected error has accord');
			} else if ($user->activated == 'activated') {
				Session::flash('message', 'This acount is already active');
			}
			return redirect()->route('login');
		}
		if ((strtotime(date('Y-m-d'))) > strtotime($user->email_send_at . " +2 days")) {
			Session::flash('message', 'This email has expired');
			return redirect()->route('register');
		}

		return view('registration.setPassword', ['token' => $token]);
	}

	/**
	 * set the users password
	 * @param $request request
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function SetPassword(Request $request)
	{
		$user = User::where('token', $request->input('token'))->first();

		if ($user == null || $user->activated == 'activated') {
			if ($user == null) {
				Session::flash('message', 'An unexpected error has accore6d');
			} else if ($user->activated == 'activated') {
				Session::flash('message', 'This acount is already active');
			}
			return redirect()->route('login');
		}

		if ((strtotime(date('Y-m-d'))) > strtotime($user->email_send_at . " +2 days")) {
			Session::flash('message', 'This email has expired');
			return redirect()->route('register');
		}

		$validator = Validator::make($request->all(), [
			  'password' => 'required|min:6|max:255',
			  'password_confirmation' => 'same:password'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator);
		}

		$user->password = Hash::make($request->input('password'));
		$user->activated = 'activated';

		$user->save();

		Session::flash('positive', true);
		Session::flash('message', 'Succes you can now log in');

		return redirect('login');
	}

	/*	 * *
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function register(Request $request)
	{
		$this->validator($request->all())->validate();
		event(new Registered($user = $this->create($request->all())));

		Session::flash('positive', true);
		return redirect()->route('register')->with("message", "A Registration email has been send");
	}

}
