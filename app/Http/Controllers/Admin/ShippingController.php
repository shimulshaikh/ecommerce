<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingCharge;
use Session;

class ShippingController extends Controller
{
    
	public function index()
    {
    	Session::put('page','shipping-charges');

    	$shipping_charges = ShippingCharge::get()->toArray();
    	//dd($shipping_charges);
    	return view('admin.shipping.view_shipping_charges')->with(compact('shipping_charges'));
    }

}
