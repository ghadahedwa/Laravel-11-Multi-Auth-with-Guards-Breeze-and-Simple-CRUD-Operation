<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::get();
        if(count($products)>0) {
            return ProductResource::collection($products);
        }
        else{
            return response()->json(['message'=>'No records'],200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'description'=>'required|string',
            'price'=>'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'All fileds reuired',
                'error'=>$validator->messages()
            ],422);
        }

        $product=Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
        ]);

        return response()->json([
            'message'=>'Created Sucessfully',
            'data'=>$product
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validator=Validator::make(
            $request->all(),[
            'name'=>'required|string|max:255',
            'description'=>'required',
            'price'=>'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'All fileds reuired',
                'error'=>$validator->messages()
            ],422);
        }

        $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
        ]);

        return response()->json([
            'message'=>'Updated Sucessfully',
            'data'=>new ProductResource($product)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message'=>'Deleted Sucessfully'],200);
    }
}
