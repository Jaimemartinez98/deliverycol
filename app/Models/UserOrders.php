<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrders extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurants');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatuses', 'id', 'order_status_id');
    }

    public function products_order(){
        return $this->hasMany('App\Models\ProductsOrders', 'user_order_id', 'id');
    }


    
}
