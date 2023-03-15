<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurants');
    }

    // public function products_order(){
    //     return $this->hasMany('App\Models\ProductsOrders', 'product_id', 'id');
    // }

}
