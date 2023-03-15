<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOrders;
use App\Models\ProductsOrders;
use Auth;
use Illuminate\Support\Facades\Validator;

class UserOrdersController extends Controller
{
    public function getOrdersByRestaurant(Request $request){

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'order_status_id' => 'required|numeric',
        ],[
            'order_status_id.required' => 'El ID del estatus es requerido',
            'order_status_id.numeric' => 'El ID del estatus debe ser númerico',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orders = UserOrders::where('restaurant_id', $user->restaurant_id)
        ->with([
            'user' => function($query) {
                $query->select('id', 'name');
            },
            'status' => function($query) {
                $query->select('id', 'name');
            },
            'products_order' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->select('id', 'name');
                    },
                ]);
            },
        ])
        ->where('order_status_id', $request->order_status_id)
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json([
            'orders' => $orders
        ]);

    }

    public function getOrdersByUser(){

        $user = Auth::user();

        $orders = UserOrders::where('user_id', $user->id)
        ->with([
            'restaurant' => function($query) {
                $query->select('id', 'name');
            },
            'status' => function($query) {
                $query->select('id', 'name');
            },
            'products_order' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->select('id', 'name');
                    },
                ]);
            },
        ])
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json([
            'orders' => $orders
        ]);

    }


    public function createOrder(Request $request){

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|numeric',
            'products' => 'required',
        ],[
            'restaurant_id.required' => 'El ID del restaurante es requerido',
            'restaurant_id.numeric' => 'El ID del restaurante debe ser númerico',
            'products.required' => 'Los productos son requeridos',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user_order = new UserOrders;
        $user_order->user_id = $user->id;
        $user_order->restaurant_id = $request->restaurant_id;
        $user_order->order_status_id = 1;
        $user_order->save();

        foreach($request->products as $product){
            $product_order = new ProductsOrders;
            $product_order->user_order_id = $user_order->id;
            $product_order->product_id = $product['id'];
            $product_order->amount = $product['amount'];
            $product_order->save();
        }
        
        return response()->json("Orden realizada con exito", 200);
    }

    public function showOrder($id){

        $order = UserOrders::where('id', $id)
        ->with([
            'user' => function($query) {
                $query->select('id', 'name');
            },
            'restaurant' => function($query) {
                $query->select('id', 'name');
            },
            'status' => function($query) {
                $query->select('id', 'name');
            },
            'products_order' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->select('id', 'name');
                    },
                ]);
            },
        ])
        ->first();

        return response()->json($order);

    }

    public function changeStatus(Request $request){

        $user_order = UserOrders::where('id', $request->id)->first();

        if (!$user_order) {
            return response()->json("La orden que intenta actualizar no existe", 422);
        }

        $validator = Validator::make($request->all(), [
            'status_id' => 'required|numeric',
        ],[
            'status_id.required' => 'El ID del estatus es requerido',
            'status_id.numeric' => 'El ID del estatus debe ser númerico',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user_order->order_status_id = $request->status_id;
        $user_order->save();

        return response()->json($user_order);

    }

    
}
