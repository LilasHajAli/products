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
        return response()->json(Product::all()) ;
    }

    public function store(StoreProductRequest $request )
    {
       $product= Product::query()->create($request->validated());
        return response()->json($product , 201);
    }
    public function show($id)
 {
    $product= Product::query()->where('id' ,$id)->get();
    if($product->isNotEmpty()){
            return response()->json($product);
    }
     return response()->json(['message'=>'not found'],404);
 }

public function update(UpdateProductRequest $request, $id)
{
    $product = Product::find($id);

    if (!$product)
         {
        return response()->json([
            'message' => 'product not found'], 404);
        }

    $product->update($request->validated());
    return response()->json($product, 200);
}

public function destroy($id)
{
Product::query()->where('id', $id)->delete();

return response()->json(['message'=> 'product deleted successfully'], 200);
}


 public function reduceStock(ReduceProductStore $request, $id)
{
$product = Product::find($id);
$product->quantity = $product->quantity - $request->amount;
$product->save();

return 'success';
}
}
