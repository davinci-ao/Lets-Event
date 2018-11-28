<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Models\User;

class ForgotPasswordController extends Controller
{
	/*
	  |--------------------------------------------------------------------------
	  | Password Reset Controller
	  |--------------------------------------------------------------------------
	  |
	  | This controller is responsible for handling password reset emails and
	  | includes a trait which assists in sending these notifications from
	  | your application to your users. Feel free to explore this trait.
	  |
	 */

use SendsPasswordResetEmails;

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
	 * Send a reset link to the given user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
	 */
	public function sendResetLinkEmail(Request $request)
	{
		$this->validateEmail($request);

		$user = User::Where('email', $request->email)->first();

		if ($user == null) {
			return redirect()->route('password.request')->withErrors(['no_acount_found' => 'No account found']);
		}

		if ($user->activated == 'not activated') {
			return redirect()->route('password.request')->withErrors(['acount_not_active' => 'This account is not activated']);
		}

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$response = $this->broker()->sendResetLink($request->only('email'));

		return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($response) : $this->sendResetLinkFailedResponse($request, $response);
	}

}
