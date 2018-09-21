<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use Illuminate\Support\Facades\DB;
use Session;

/**
 * Description of CategoryController
 *
 * @author Peter Verhaar
 */
class CategoryController extends Controller
{

	/**
	 * Loads the web page with the corresponding parameter value supplied from $parra
	 * @param type $parra
	 * @return type view
	 */
	public function index()
	{
		Session::flash('');
		$categories = Category::all();
		return view('categoryPage', ['categories' => $categories]);
	}

	/**
	 * Gives the category model the data from the form POST
	 * and generates a flash message
	 * @return type view
	 */
	public function createCategory()
	{
		$catergoryData = $_POST;
		
		if (count($catergoryData["categoryName"]) == 0 || $catergoryData["categoryName"] == "") {
			Session::flash('emptyInputMessage', 'Category');
			return view('categoryPage');
		}
		if (count($catergoryData["categoryName"]) > 40) {
			Session::flash('toLongInputMessage', 'Category');
			return view('categoryPage');
		}
		$category = new Category();
		if ($category->saveCategoryData($catergoryData) === true) {
			Session::flash('succesMessage', 'Category');
		} elseif ($category->saveCategoryData($catergoryData) === false) {
			Session::flash('failMessage', 'Category');
		}

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
	public function deleteCategory(Request $request, $category_id)
	{
		Category::where('id', $category_id)->delete();
	}

}
