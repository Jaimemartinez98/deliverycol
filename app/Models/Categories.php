<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    public function restaurants(){
        return $this->belongsToMany('App\Models\RestaurantCategories','restaurant_categories','restaurant_id','category_id');
    }

}
