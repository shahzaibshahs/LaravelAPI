<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    function addProduct(Request $request)
    {
        $product = new Product;
        $product->name=$request->input('name');
        $product->price=$request->input('price');
        $product->description=$request->input('description');
        $product->file_path=$request->file('file')->store('products');
        $product->save();
        return $product;
    }

    function list()
    {
        return Product::all();
    }

    function delete($id)
    {
        $result = Product::where('id',$id)->delete();
        if($result)
        {
            return ["result"=>"Product has been deleted"];
        }
        else{
            return ["result"=>"Operation Failed"];
        }
    }

    function getProduct($id)
    {
        return Product::find($id);
    }

    function updateProduct($id, Request $request)
    {
       
         // Find the product by its ID
    $product = Product::find($id);

    // Check if the product with the given ID exists
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // Update product properties based on request input
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->description = $request->input('description');

    // Handle file upload if a file is included in the request
    if ($request->hasFile('file')) {
        // Store the file in the 'products' directory under storage/app/public/
        $product->file_path = $request->file('file')->store('products', 'public');
    }

    // Save the updated product
    $product->save();

    // Return the updated product as JSON response
    return response()->json($product);

        // $product= Product::find($id);
        // $product->name=$request->input('name');
        // $product->price=$request->input('price');
        // $product->description=$request->input('description');
        // if($request->file('file'))
        // {
        //     $product->file_path=$request('file')->store('products');
        // }
        // $product->save();
        // return $product;
    }

    function search($key)
    {
        return Product::where('name','Like',"%$key%",)->get();
    }

}
