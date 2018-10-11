<?php

namespace App\Http\Models;

/**
 * Description of Category this is the model for the categories
 *
 * @author Peter Verhaar
 */
class Category extends \Illuminate\Database\Eloquent\Model
{

	public $table = "categories";
	protected $fillable = ['name'];

	public function events()
	{
		return $this->belongsToMany('App\Http\Models\Event');
	}
}
