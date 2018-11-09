<?php

/**
 * Locations model
 *
 * @author team Yugioh
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class locations extends Model
{
	protected $fillable = ['id', 'name'];

	public function events()
	{
		return $this->hasMany('App\Http\Models\Event', 'location_id', 'id');
	}

	public function createLocation($name)
	{
		return self::create(['name' => $name]);
	}

	public function editLocation($name)
	{		
		$this->name = $name;
		$this->save();
	}
}
