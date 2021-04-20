<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guard = 'orders';

    protected $fillable = [
        'user_id', 'name', 'address', 'city', 'state', 'country', 'pincode','mobile','email','shipping_charges','shipping_charges','coupon_amount','order_status','payment_method','payment_gateway','grand_total'
    ];

    public function orders_product()
    {
    	return $this->hasMany('App\OrdersProduct', 'order_id');
    }

}
