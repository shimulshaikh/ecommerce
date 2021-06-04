<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($country)
    {
    	$shippingDetails = ShippingCharge::where('country', $country)->first()->toArray();
    	$shipping_charges = $shippingDetails['shipping_charges'];

    	return $shipping_charges;
    }
}
