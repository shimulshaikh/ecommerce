<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Cart;
use Response;
use Session;
use Auth;
use Mail;

class UsersController extends Controller
{
    
	public function loginRegister()
	{
		return view('front.users.login_register');
	}

	public function registerUser(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();
			// echo "<pre>"; print_r($data); die;

			//check if user already exists
			$userCount = User::where('email',$data['email'])->count();
			if ($userCount>0) {
				Session::flash('error', 'Email already exists!');
                return redirect()->back();
			}else{
				//Register the user
				$user = new User;
				$user->name = $data['name'];
				$user->mobile = $data['mobile'];
				$user->email = $data['email'];
				$user->password = bcrypt($data['password']);
				$user->status = 1;
				$user->save();

				if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
					// echo "<pre>"; print_r(Auth::user()); die;
					//update user cart with user id
					if (!empty(Session::get('session_id'))) {
						$user_id = Auth::user()->id;
						$session_id = Session::get('session_id');
						Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
					}

					//Send Register Email
					$email = $data['email'];
					$messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
					Mail::send('emails.register',$messageData,function($message) use($email){
						$message->to($email)->subject('Welcome to E-commerce Website');
					});

					return redirect('cart');
				}
			}
		}
	}

	public function checkEmail(Request $request)
	{
		//check if email already exists
		$data = $request->all();
		$emailCount = User::where('email',$data['email'])->count();
		if ($emailCount>0) {
			return "false";
		}else{
			return "true";
		}
	}

	public function loginUser(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();
			// echo "<pre>"; print_r($data); die;
			if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {

				//update user cart with user id
				if (!empty(Session::get('session_id'))) {
					$user_id = Auth::user()->id;
					$session_id = Session::get('session_id');
					Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
				}
				return redirect('/cart');
			}else{
				Session::flash('error', 'Invalid Username or Password!');
                return redirect()->back();
			}
		}
	}

	public function logoutUser()
	{
		Auth::logout();
		return redirect('/');
	}

	public function userAccount()
	{
		
	}

}
