<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guard = 'brands';

    protected $fillable = [
    	'name', 'status'
    ];
}
