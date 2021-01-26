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
				$user->status = 0;
				$user->save();

				//send Confirmation Mail
				$email = $data['email'];
				$messageData = [
					'email' => $data['email'],
					'name' => $data['name'],
					'code' => base64_encode($data['email'])
				];

				Mail::send('emails.confirmation',$messageData, function($message) use($email){
					$message->to($email)->subject('Confirm your E-commerce Account');
				});

				//Redirect back with Success Message
				Session::flash('success', 'Please confirm your email to activate your account!');
                return redirect()->back();

				// if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
				// 	// echo "<pre>"; print_r(Auth::user()); die;
				// 	//update user cart with user id
				// 	if (!empty(Session::get('session_id'))) {
				// 		$user_id = Auth::user()->id;
				// 		$session_id = Session::get('session_id');
				// 		Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
				// 	}

				// 	//Send Register Email
				// 	$email = $data['email'];
				// 	$messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
				// 	Mail::send('emails.register',$messageData,function($message) use($email){
				// 		$message->to($email)->subject('Welcome to E-commerce Website');
				// 	});

				// 	return redirect('cart');
				// }
			}
		}
	}

	public function confirmAccount($email)
	{
		//decode user email
		$email = base64_decode($email);

		//check user email exists
		$userCount = User::where('email',$email)->count();
		if ($userCount>0) {
			//user email is already activated or not 
			$userDetails = User::where('email',$email)->first();
			if ($userDetails->status==1) {
				Session::flash('error', 'Your Email account is already activated. Please login.');
				return redirect('login-register');
			}else{
				//update user status to 1 to activate account
				User::where('email',$email)->update(['status'=>1]);

				//Send Register Email
				$messageData = ['name'=>$userDetails['name'],'mobile'=>$userDetails['mobile'],'email'=>$email];
				Mail::send('emails.register',$messageData,function($message) use($email){
					$message->to($email)->subject('Welcome to E-commerce Website');
				});	

				Session::flash('success', 'Your Email account is already activated!. You can login now.');
                return redirect('login-register');				
			}
		}else{
			abort(404);
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
				//check email is activated or not
				$userStatus = User::where('email',$data['email'])->first();
				if ($userStatus->status == 0) {
					Auth::logout();
					Session::flash('error', 'Your account is not activated yet! Please confirm your email to activete!');
                	return redirect()->back();
				}

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

	public function forgotPassword(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();
			// echo "<pre>"; print_r($data); die;

			$emailCount = User::where('email',$data['email'])->count();
			if ($emailCount == 0) {
				Session::flash('error', 'Email does not exists!');
                	return redirect()->back();
			}

			//Generate Random Password
			$random_pass = str_random(8);

			//Encode/secure Password
			$new_pass = bcrypt($random_pass);

			//update password
			USer::where('email',$data['email'])->update(['password'=>$new_pass]);

			//Get user name
			$userName = User::select('name')->where('email',$data['email'])->first();

			//send forgot password email
			$name = $userName->name;
			$email = $data['email'];
			$messageData = [
					'email' => $email,
					'name' => $name,
					'password' => $random_pass
				];
			Mail::send('emails.forgot_password',$messageData,function($message) use($email){
					$message->to($email)->subject('New password - E-commerce Website');
				});	

			Session::flash('success', 'Please check your email for new password!');
            return redirect('login-register');	

		}
		return view('front.users.forgot_password');
	}

	public function userAccount()
	{
		
	}

}
