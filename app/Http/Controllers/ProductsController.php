<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:products|max:255',
            'text' => 'required',
            'price' => 'integer',
            'availability' => 'boolean',
        ]);

        if(!isset($request['slug'])) {
            $request['slug'] = str_slug($request['name'], "-");
        }

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        if(!isset($request['slug'])) {
            $request['slug'] = str_slug($request['name'], "-");
        }
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
