<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Category\Category;
use Session;

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
	public function index()
	{
		Session::flash('');
		return view('categoryPage');
	}

	/**
	 * Gives the category model the data from the form POST
	 * and generates a flash message
	 * @return type view
	 */
	public function createCategory()
	{

		$catergoryData = $_POST;
		$category = new Category();
		$result = $category->saveCategoryData($catergoryData);

		$this->categoryStatus = $result;
		if ($this->categoryStatus === true) {
			Session::flash('message', 'Category Added');
		}
		$this->categoryStatus = null;
		return view('categoryPage');
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
