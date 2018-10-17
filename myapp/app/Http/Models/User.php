<?php

/**
 * User model
 *
 * @author team Yugioh
 */

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'firstname', 'lastname', 'email', 'password', 'student_nr', 'firstname', 'lastname', 'education_location_id', 'activated', 'role'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	    'password', 'remember_token',
	];

}
