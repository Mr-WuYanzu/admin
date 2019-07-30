<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\goods\Goods;

class Cart extends Model
{
    protected $table = 'shop_cart_1';
    public $primaryKey = 'cart_id';
    public function Goods(){
        return $this->hasOne('App\goods\Goods','goods_id','goods_id');
    }
}
