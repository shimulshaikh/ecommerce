<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersLog extends Model
{
    use HasFactory;

    protected $guard = 'orders_logs';

    protected $fillable = [
    	'order_id', 'order_status'
    ];
}
