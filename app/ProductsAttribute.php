<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    protected $table = 'products_attributes';

    protected $fillable = [
    	'product_id', 'size', 'price', 'stock', 'sku', 'status'
    ];
}
