<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReduceProductStore;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
    {
        return Product::all();
    }

    public function store(StoreProductRequest $request )
    {
        Product::query()->create($request->validated());
        return 'success';
    }
    public function show($id)
 {
    return Product::query()->where('id' ,$id)->get();
 }

 public function update(UpdateProductRequest $request , $id)
 {
    return Product::query()->where('id' ,$id)->update($request->validated());
 }
 public function destroy(UpdateProductRequest $request ,$id)
 {
    Product::query()->where('id', $id)->update($request->validated());
 }


public function reduceStock(ReduceProductStore $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return 'product not found';
    }

    if ($request->amount > $product->quantity) {
        return 'not enough stock';
    }

    $product->quantity = $product->quantity - $request->amount;
    $product->save();

    return 'success';
}
}
