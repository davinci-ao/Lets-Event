<?php

namespace App\Http\Category;

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
		$category = $this->create([
		    "name" => $catergoryData['categoryName']
		]);

		return $category;
	}

}
