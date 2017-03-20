<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenElement extends Model
{
    protected $table = 'token_elements';

    public function order()
    {
        return $this->belongsToMany('App\TokenOrder', 'element_orders', 'element_id', 'order_id');
    }
}
