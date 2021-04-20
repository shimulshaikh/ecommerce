<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProduct extends Model
{
    use HasFactory;

    protected $guard = 'orders_products';

    protected $fillable = [
        'order_id', 'user_id', 'product_id', 'product_code', 'product_name', 'product_color', 'product_size','product_price','product_qty'
    ];
}
