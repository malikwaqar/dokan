<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|min:4',
            'slug'=>'required|min:4|unique:categories'
        ]);
        $categories = Category::create($request->only('title','description','slug'));
        $categories->childrens()->attach($request->parent_id);
        return back()->with('message','Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id','!=', $category->id)->get();
        return view('admin.categories.edit',['categories' => $categories, 'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->parents()->detach();
        //attach selected parent categories
        $category->parents()->attach($request->parent_id,['created_at'=>now(), 'updated_at'=>now()]);
        //save current record into database
        $saved = $category->save();
        if($saved)
            return redirect()->back()->with('message','Record Successfully Updated!');
        else
            return back()->with('message', 'Error Updating Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->childrens()->detach() && $category->forceDelete()){
            return back()->with('message','Category Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }
}
