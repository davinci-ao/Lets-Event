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
	    'firstname', 'lastname', 'email', 'password', 'student_nr', 'firstname', 'lastname', 'education_location_id', 'activated', 'role', 'status'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	    'password', 'remember_token',
	];

	public function importCsvData($studentNumber, $prefix, $firstname, $lastname)
	{
		try {
			return $this->firstOrCreate([
				'student_nr' => $studentNumber,
				'firstname' => $firstname,
				'lastname' => $prefix . ' ' . $lastname,
				'email' => $studentNumber. '@mydavinci.nl',
				'password' => '',
				'education_location_id' => 0
			]);
		} catch (\Exception $e) {
			return false;
		}
		
	}

	public function events()
	{
		return $this->belongsToMany('App\Http\Models\Event', 'participations');
	}

}
