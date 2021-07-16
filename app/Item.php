<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function order(){
        return $this->belongsTo('App/Order', 'order_id', 'id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
