<?php

namespace App\Http\Controllers;

use App\Http\Models\Category;
use Illuminate\Http\Request;
use Validator;
use session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index', ['categories' => Category::paginate(10)]);
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
        $validator = Validator::make($request->all(), [
            'name' => 
            ['required',
                'max:40',
                function ($attribute, $value, $fail) {

                    $category = new Category();
                    $category = $category->where('name', $value)->get();

                    if ( $category->isNotEmpty() ) {
                        return $fail('Category creation failed, The category "' . ucfirst(strtolower($value)) . '" already exsist');
                    }

                }
            ]
        ]);

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
        $validator = Validator::make($request->all(), [
            'id' =>
            ['required',
                function ($attribute, $value, $fail) {
                    $category = new Category();
                    $category = $category->find($value);

                    if ( $category->name === ucfirst(strtolower($value)) ) {
                        return $fail('This category already exsist');
                    }

                    if (!isset($category->id)) {
                        return $fail('Category not found');
                    }
                }],
            'name' => 'required|max:40',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category->find($request->input('id'))->editCategory($request);

        return redirect('/category');
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
}