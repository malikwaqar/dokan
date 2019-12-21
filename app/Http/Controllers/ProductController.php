<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\CategoryParent;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::with('childrens')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $path = 'images/no-thumbnail.jpeg';
        if($request->has('thumbnail')){
            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(), $extension).time();
            $name = $name.$extension;
            $path = $request->thumbnail->storeAs('images', $name, 'public');
        }
        $product = Product::create([
            'title'=>$request->title,
            'slug' => $request->slug,
            'description'=>$request->description,
            'thumbnail' => $path,
            'status' => $request->status,
            'options' => isset($request->extras) ? json_encode($request->extras) : null,
            'featured' => ($request->featured) ? $request->featured : 0,
            'price' => $request->price,
            'discount'=>$request->discount ? $request->discount : 0,
            'discount_price' => ($request->discount_price) ? $request->discount_price : 0,
        ]);
        if($product){
            $product->categories()->attach($request->category_id,['created_at'=>now(), 'updated_at'=>now()]);
            return redirect(route('admin.product.create'))->with('message', 'Product Successfully Added');
        }else{
            return back()->with('message', 'Error Inserting Product');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(5);
        return view('admin.products.index', compact('products'));
    }
    public function recoverProduct($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        if($product->restore())
            return back()->with('message','Product Successfully Restored!');
        else
            return back()->with('message','Error Restoring Product');
    }
}
