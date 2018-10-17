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

	public function createCategory($name)
	{
		return self::create([
			'name' => $name
		]);
	}

	public function editCategory($request)
	{		
		$this->name = $request->input('name');
		$this->save();
	}

	public function deleteCategory()
	{
		$this->events()->detach();
		$this->delete();

		return $this; 
	}
}
