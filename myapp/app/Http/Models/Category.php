<?php
/**
 * Description of Category this is the model for the categories
 *
 * @author team Yugioh
 */

namespace App\Http\Models;

class Category extends \Illuminate\Database\Eloquent\Model
{

	public $table = "categories";
	protected $fillable = ['name'];

	public function events()
	{
		return $this->belongsToMany('App\Http\Models\Event');
	}
}
