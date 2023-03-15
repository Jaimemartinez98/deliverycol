<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Auth;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index(){
        $user = Auth::user();

        $products = Products::select('id','name','description','price')->where('restaurant_id', $user->restaurant_id)->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function store(Request $request){

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ],[
            'name.required' => 'El nombre es requerido',
            'description.required' => 'La descripción es requerida',
            'price.required' => 'El precio es requerido',
            'price.numeric' => 'El precio debe ser númerico',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = new Products;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->restaurant_id = $user->restaurant_id;
        $product->save();

        return response()->json($product,200);

    }

    public function show($id){
        $product = Products::find($id);

        if (!$product) {
            return response()->json("El producto que intenta buscar no existe", 422);
        }

        return response()->json($product,200);
    }

    public function update(Request $request){
        
        $product = Products::select('id','name','description')->where('id', $request->id)->first();

        if (!$product) {
            return response()->json("El producto que intenta actualizar no existe", 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ],[
            'name.required' => 'El nombre es requerido',
            'description.required' => 'La descripción es requerida',
            'price.required' => 'El precio es requerido',
            'price.numeric' => 'El precio debe ser númerico',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return response()->json($product,200);

    }

    public function delete(Request $request){

        $product = Products::where('id', $request->id)->first();   
        if (!$product) {
            return response()->json("El producto que intenta actualizar no existe", 422);
        }
        $product->delete();

        return response()->json("Eliminado con exito",200);   

    }

}
