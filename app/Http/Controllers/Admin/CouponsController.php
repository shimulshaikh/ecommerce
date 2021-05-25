<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CouponSendUser;
use App\Coupon;
use App\User;
use App\Section;
use App\Category;
use Session;
use Mail;
use Carbon\Carbon;

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


    public function addEditCoupon(Request $request,$id=null)
    {
    	if ($id=="") {
    		//Add coupon
    		$selCats = array();
    		$selUsers = array();
    		$coupon = new Coupon;
    		$title = "Add Coupon";
    		$message = "Coupon added successfully";

    	}else{
    		//Update Coupon
    		$coupon = Coupon::find($id);
    		$selCats = explode(',', $coupon['categories']);
    		$selUsers = explode(',', $coupon['users']);
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
                'users' => 'required',
                'expiry_date' => 'required'
            ];

            $customMessages = [
                'categories.required' => 'Select Category',
                'users.required' => 'Select users',
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

            if ($data['coupon_option']=="Automatic") {
                $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_option'];
            }

            if (isset($data['categories'])) {
                $categories =implode(',', $data['categories']);
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

             // $category= array();

            // foreach ($data['categories'] as $catID) {
            //     $category[] = Category::where('id', $catID)->select('category_name')->get()->toArray();
            // }
            // dd($category);

            foreach ($data['users'] as $user) {
                 $email = $user;
                $messageData = [
                    'email' => $email,
                    // 'category' => $category,
                    'coupon_type' => $data['coupon_type'],
                    'coupon_code' => $coupon_code,
                    'amount' => $data['amount'],
                    'amount_type' => $data['amount_type'],
                    'expiry_date' => $data['expiry_date']
                ];

                // Mail::send('emails.coupon_user_email', $messageData, function($message) use($email){
                //     $message->to($email)->subject('Coupon code For You');
                // });

                //notification
                $when = Carbon::now()->addSeconds(10);
                //Notification::send($user, (new CouponSendUser($messageData))->delay($delay));
                Notification::route('mail', $email)->notify((new CouponSendUser($messageData))->delay($when));
            }

    		Session::flash('success',$message);
    		return redirect('admin/coupons');
    	}

    	//select with cateroies and sub categories
    	$categories = Section::with('categories')->get();

    	//User
    	$users = User::select('email')->where('status',1)->get()->toArray();

    	return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','users','selCats','selUsers'));
    }

    public function destroyCoupon($id)
    {
        $coupon = Coupon::find($id);

        $coupon->delete();    

        Session::flash('success', 'Coupon Deleted Successfully');
        return redirect()->back();
    }



}
