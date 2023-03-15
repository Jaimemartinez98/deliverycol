<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurants;

class RestaurantsController extends Controller
{
    public function index(){

        $restaurants = Restaurants::select('id','name','description','address','url_path')
        ->with([            
            'categories' => function($query) {
                $query->select('name');
            },
        ])
        ->get();

        return response()->json([
            'restaurants' => $restaurants
        ]);
    }

    public function show($id){

        $restaurant = Restaurants::select('id','name','description','address','url_path')
        ->with([  
            'products' => function($query) {
                $query->select('id','restaurant_id','name','description','price');
            },          
            'categories' => function($query) {
                $query->select('name');
            },
        ])
        ->where('id', $id)
        ->first();

        return response()->json([
            'restaurant' => $restaurant
        ]);
    }


    
}
