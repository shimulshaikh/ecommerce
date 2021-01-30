<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use App\User;
use App\Section;
use Session;

class CouponsController extends Controller
{
    
	public function coupons()
	{
		Session::put('page','coupons');
		$coupons = Coupon::get()->toArray();
        
        return view('admin.coupons.coupons')->with(compact('coupons'));
	}

	public function updateCouponStatus(Request $request)
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
            Coupon::where('id', $data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'coupon_id'=>$data['coupon_id']]);
        }   
    }


    public function addEditCoupon(Request $request, $id=null)
    {
    	if ($id=="") {
    		//Add coupon
    		$coupon = new Coupon;
    		$title = "Add Coupon";
    		$message = "Coupon added successfully";

    	}else{
    		//Update Coupon
    		$coupon = Coupon::find($id);
    		$title = "Edit Coupon";
    		$message = "Coupon updated successfully";
    	}

    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		// echo "<pre>"; print_r($data); die;

    		//validation customize
            $rule = [
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required',
                'expiry_date' => 'required'
            ];

            $customMessages = [
                'categories.required' => 'Select Category',
                'coupon_option.required' => 'Select Coupon Option',
                'coupon_type.required' => 'Select Coupon Type',
                'amount_type.required' => 'Select Amount Type',
                'amount.required' => 'Enter Amount',
                'expiry_date.numeric' => 'Enter Expiry Date',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

    		if (isset($data['users'])) {
    			$users =implode(',', $data['users']);
    		}else{
    			$users ="";
    		}

    		if (isset($data['categories'])) {
    			$categories =implode(',', $data['categories']);
    		}

    		if ($data['coupon_option']=="Automatic") {
    			$coupon_code = str_random(8);
    		}else{
    			$coupon_code = $data['coupon_option'];
    		}

    		$coupon->coupon_option = $data['coupon_option'];
    		$coupon->coupon_code = $coupon_code;
    		$coupon->categories = $categories;
    		$coupon->users = $users;
    		$coupon->coupon_type = $data['coupon_type'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->amount = $data['amount'];
    		$coupon->expiry_date = $data['expiry_date'];
    		$coupon->status = 1;
    		$coupon->save();

    		Session::flash('success',$message);
    		return redirect('admin/coupons');
    	}

    	//select with cateroies and sub categories
    	$categories = Section::with('categories')->get();

    	//User
    	$users = User::select('email')->where('status',1)->get()->toArray();

    	return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','users'));
    }



}
