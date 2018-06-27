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

	public function saveCategoryData($catergoryData)
	{
		$category = $this->create([
		    "name" => $catergoryData['categoryName']
		]);

		return $category;
	}

}
