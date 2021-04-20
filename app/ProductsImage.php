<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model
{
    protected $guard = 'products_images';

    protected $fillable = [
    	'product_id', 'image', 'status'
    ];
}
