<?php

namespace App\Http\Controllers;

use App\Http\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index', ['categories' => Category::paginate(8), 'user' => auth()->user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateCategory($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category = new Category();
        $category = $category->createCategory(ucfirst(strtolower($request->input('name'))));

        return back()->with('message', 'Category Creation is succesfull , ' . $category->name . ' Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('category.show', ['category' => Category::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('category.edit', ['category' => Category::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateCategory($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category = new Category();
        $category->find($request->input('id'))->editCategory($request);

        return redirect('/category')->with('message', 'the category has been succesvol edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id)->deleteCategory();

        return redirect('/category')->with('message', $category->name . " Has been deleted succesfully" );
    }

    private function validateCategory($request)
    {
        return $validator = Validator::make($request->all(), [
            'name' => 'required|max:40|unique:categories,name',
        ]);
    }
}