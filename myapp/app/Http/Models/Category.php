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

	/**
	 * Saves the category name to the database with the data from categoryData array
	 * @param type $catergoryData
	 * @return type array
	 */
	public function saveCategoryData($catergoryData)
	{	
		if ($this->where("name", "=", $catergoryData['categoryName'])->count() > 0) {
			return false;
		}
		
		$this->create([
		    "name" => $catergoryData['categoryName']
		]);
		
		return true;
	}

}
