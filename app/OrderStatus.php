<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $guard = 'order_statuses';

    protected $fillable = [
    	'name', 'status'
    ];

}
