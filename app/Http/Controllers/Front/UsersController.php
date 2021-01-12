<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Response;
use Session;
use Auth;

class UsersController extends Controller
{
    
	public function loginRegister()
	{
		return view('front.users.login_register');
	}

	public function loginUser()
	{
		
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
					return redirect('cart');
				}
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
