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
				'education_location_id' => 1,
				'role' => 'student',
				'activated' => 'not activated'
			]);
		} catch (\Exception $e) {
			return false;
		}
		
	}

	public function editUser($data)
	{
		if ( empty($data['status']) ) $data['status'] = $this->status;
		
        $this->fill([
		    "firstname" => $data['firstname'],
		    "lastname" => $data['lastname'],
		    "student_nr" => $data['student_number'],
		    "education_location_id" => $data['location'],
            "email" => $data['email'],
		    "activated" => $data['activated'],
		    "role" => $data['role'], 
		    "status" => $data['status']
		]);

		return $this->save();
	}

	public function events()
	{
		return $this->belongsToMany('App\Http\Models\Event', 'participations');
	}

}
