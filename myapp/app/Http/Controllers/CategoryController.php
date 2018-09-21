<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use Illuminate\Support\Facades\DB;
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
	public function deleteCategory(Request $request, $category_id)
	{	
		$category = Category::where('id', '=', $category_id)->first();// get name where id
		Category::where('id', $category_id)->delete(); // delete category where id

		Session::flash('status', 'Category '. $category->name . ' successful deleted! '); // message

		return redirect('category/index');// return blade
	}

}