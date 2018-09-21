<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Category\Category;
use Session;
use Validator;

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
		return view('categoryPage');
	}

	/**
	 * Gives the category model the data from the form POST
	 * and generates a flash message
	 * @return type view
	 */
	public function createCategory()
	{
		if (isset($_POST)) {
			$catergoryData = $_POST;
			$category = new Category();
			if ($category->saveCategoryData($catergoryData) === true) {
				Session::flash('succesmessage', 'Category');
			} elseif ($category->saveCategoryData($catergoryData) === false) {
				Session::flash('failmessage', 'Category');
			}
			
		}

		return view('categoryPage');
	}

	/**
	 * @param id  
	 * load the category according to the id
	 *
	 * @return type view
	 */
	public function editCategory($id)
	{
		$category = new Category();
		$category = $category::find($id);

		if ( !isset($category->id) ) {
			return redirect('category/index')->with('message', 'Category not found');
		}

		return view('categoryEdit', ['category' => $category]);
	}

	/**
	 * Validate the request and edit the category
	 * @param id  
	 *
	 * @return type view
	 */
	public function editCategoryAction(Request $request)
	{
		$category = new Category();

		$validator = Validator::make($request->all(), [
			'id' => 
				['required',
				function($attribute, $value, $fail) {
					$category = new Category();
					$category = $category->find($value);
						
					if (! isset($category->id) ) {
						return $fail('Category not found');
					}
				}],
			'categoryName' => 'required|max:40'
		]);

		if ($validator->fails()) {
    		return back()->withErrors($validator);		
    	}

		$category = new Category();
		$category = $category->find($request->input('id'));

		$category->name = $request->input('categoryName');

		$category->save();

		Session::flash('positive', true);

		return redirect('category/index')->with('message', 'Category succesvol edited');
	}

	/**
	 * 
	 */
	public function deleteCategory()
	{
		
	}

}