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

	/**
	 *  loads the web page for the categories
	 */
	public function index($id)
	{
		if ($id === "all") {
			return view('categoryPage');
		} elseif ($id === "create") {
			return view('categoryCreate');
		}
	}

	/**
	 *  Gives the saveCategoryData function the catergoryData
	 */
	public function createCategory()
	{
		$catergoryData = $_POST;
		$category = new Category();
		$category->saveCategoryData($catergoryData);

		return back();
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
