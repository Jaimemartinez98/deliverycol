<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany('App\Models\Products', 'restaurant_id', 'id');
    }

    public function orders(){
        return $this->hasMany('App\Models\UserOrders', 'restaurant_id', 'id');
    }

    public function categories(){
        return $this->belongsToMany('App\Models\Categories','restaurant_categories','restaurant_id','category_id');
    }

    

}
