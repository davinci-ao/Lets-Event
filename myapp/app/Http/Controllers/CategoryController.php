<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Category\Category;

/**
 * Description of CategoryController
 *
 * @author Peter Verhaar
 */
class CategoryController extends Controller
{
	
	private $categoryStatus;
	
	/**
	 * Loads the web page with the corresponding parameter value supplied from $parra
	 * @param type $parra
	 * @return type view
	 */
	public function index($parra)
	{

		if ($parra === "all") {
			return view('categoryPage');
		} elseif ($parra === "create") {
			if ($this->categoryStatus === true) {
				echo '<script language="javascript">';
				echo 'alert("Category Created!")';
				echo '</script>';
			}
			$this->categoryStatus = null;
			return view('categoryCreate');
		}
	}

	/**
	 *  Gives the category model the data from the form POST
	 */
	public function createCategory()
	{	
		$catergoryData = $_POST;
		$category = new Category();
		$result = $category->saveCategoryData($catergoryData);
		
		$this->categoryStatus = $result;
		return $this->index("create");
	}

	/**
	 * 
	 */
	public function editCategory()
	{
		
	}

	/**
	 * 
	 */
	public function deleteCategory()
	{
		
	}

}
