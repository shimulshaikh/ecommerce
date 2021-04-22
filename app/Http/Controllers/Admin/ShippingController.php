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

    public function updateShippingStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status'] == "Active"){
                $status = 0;
            }
            else{
                $status = 1;   
            }
            ShippingCharge::where('id', $data['shipping_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'shipping_id'=>$data['shipping_id']]);
        }
    }

}
