<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\Auth::user());
        if(! Gate::allows('view-products')){
            abort(403);
        }
        // return Product::with('category')->paginate(10);
        return ProductResource::collection(Product::with('category')->paginate(10));
    }

  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(CreateProductRequest $request)
    // {
    //     $product = Product::create($request->all());
    //     return response($product, Response::HTTP_CREATED);
    // }
    public function store(CreateProductRequest $request)
    {
       
        $product = Product::create($request->only('title','description','image','price'));
        return response($product, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
       

        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $product = Product::find($id);
        $product->update($request->only('title','description','image','product','category_id'));
        return response($product, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
