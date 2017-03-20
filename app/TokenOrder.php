<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenOrder extends Model
{
    protected $table = "token_orders";

    public function elements()
    {
        return $this->belongsToMany('App\TokenElement', 'element_orders', 'element_id', 'order_id');
    }
}
