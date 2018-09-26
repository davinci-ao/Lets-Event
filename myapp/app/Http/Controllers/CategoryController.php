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

		$categories = Category::get();
		return view('categoryPage', ['categories' => $categories]);
	}

	/**
	 * Gives the category model the data from the form POST
	 * and generates a flash message
	 * @return type view
	 */
	public function createCategory(Request $request)
	{	
		$validator = Validator::make($request->all(), [
			'categoryName' => 'required|max:40'
		]);
		
		if (Count(Category::where('name', $request->categoryName)->get()) > 0) {
			return back()->with('message', 'Category creation failed , "  ' .$request->categoryName. '  " already exists');
		}
		
		if ( $validator->fails() ) {
			return back()->with('message', implode('<br>', $validator->errors()->all() ));
		}

		$category = new Category();
		$category->name = $request->input('categoryName');

		$category->save();

		Session::flash('positive', true);

		return back()->with('message', 'Category Creation is succesfull , '.$category->name. ' Created');
	}

	/**
	 * @param id  
	 * load the category according to the id
	 *
	 * @return type view
	 */
	public function viewEditCategory($id)
	{
		$category = Category::find($id);
		
		if ( ! isset($category->id) ) {
			return back()->with('message', 'category not found');
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

					if (!isset($category->id)) {
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
	public function deleteCategory(Request $request, $categoryId)
	{

		$category = Category::where('id', '=', $categoryId)->first(); // get name where id
		if (isset($category->id)) {

			Category::where('id', $categoryId)->delete(); // delete category where id
			Session::flash('succes_deleted', 'Category '. $category->name . ' successful deleted! '); // message
			
			return redirect('category/index');// return blade
		}

		Session::flash('error_deleted', 'Category does not exists'); // message
		return redirect('category/index');// return blade

	}

}
