<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Session;
use App\Admin;
use Image;
use Illuminate\Support\Facades\Storage;
use Redirect,Response;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
    	Session::put('page','dashboard');

    	return view('admin.admin_dashboard');
    }

    public function settings()
    {
    	Session::put('page','settings');

    	$adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
    	return view('admin.admin_setting')->with(compact('adminDetails'));
    }

    public function login(Request $request)
    {
    	//echo $password = Hash::make('123456'); die;
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		//dd($data);

    		//validation customize
    		$rule = [
    			'email' => 'required|email|max:255',
    			'password' => 'required',
    		];

    		$customMessages = [
    			'email.required' => 'Email is required',
    			'email.email' => 'Valid email is reduired',
    			'password.required' => 'password is required',
    		];

    		$this->validate($request, $rule, $customMessages);
    		//end validation customize


    		if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
    			return redirect('admin/dashboard');
    		}else{
    			Session::flash('error', 'Invalid Email or password!');
    			return redirect()->back();
    		}
    	}
    	return view('admin.admin_login');
    }

    public function checkCurrentPwd(Request $request)
    {
    	$data = $request->all();
    	//echo "<pre>"; print_r($data); die;
    	if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
    		echo "true";
    	}else{
    		echo "false";
    	}

    }

    public function updateCurrentPwd(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;	

    		//Check if current password is correct
    		if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password))
    		{
    			//check if new and confirm password is matching
    			if($data['new_pwd'] == $data['confirm_pwd'])
    			{
    				Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
    				Session::flash('success', 'Password has been updated successfully');
    			}
    			else
    			{
    				Session::flash('error', 'New password and Confirm password not match');
    			}
		    }
		    else
		    {
		    	Session::flash('error', 'Your Current password is incorrect');
		    }

		    return redirect()->back();	
    	}
    }

    public function updateAdminDetails(Request $request)
    {
    	Session::put('page','update-admin-details');
    	
    	if ($request->isMethod('post')) {
    		$data = $request->all();

    		$rule = [
    			'name' => 'required',
    			'mobile' => 'required|numeric',
    			'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
    		];

    		$customMessages = [
    			'name.required' => 'Name is required',
    			'mobile.required' => 'Mobile is required',
    			'mobile.numeric' => 'Valid Mobile is required',
    			'image.image' => 'Valid Image is required',
    		];

    		$this->validate($request, $rule, $customMessages);

    		$image = $request->file('image');

    		if(isset($image)){

            //make unique name for image
            $currentDate = Carbon::now()->toDateString();

            $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //check admin dir is exists
            if (!Storage::disk('public')->exists('admin_image')) 
            {
                Storage::disk('public')->makeDirectory('admin_image');
            }

            //delete old admin image
            if (Storage::disk('public')->exists('admin_image/'.Auth::guard('admin')->user()->image))
            {
                Storage::disk('public')->delete('admin_image/'.Auth::guard('admin')->user()->image);
            }

            //resize image for admin and upload
            $img = Image::make($image)->resize(160,160)->save(storage_path('app/public/admin_image').'/'.$imageName);
            Storage::disk('public')->put('admin_image/'.$imageName,$img);
        	}
        	else{
        		$imageName = Auth::guard('admin')->user()->image;
        	}

    		//update ADmin details
    		Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=> $data['name'], 'mobile'=>$data['mobile'], 'image'=> $imageName]);
    		Session::flash('success', 'Admin details updated successfully');
    		return redirect()->back();

    	}

    	return view('admin.update_admin_details');	
    }

    public function logout()
    {
    	Auth::guard('admin')->logout();
    	return redirect('/admin');
    }
}
