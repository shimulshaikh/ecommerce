@extends('layouts.front_layouts.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">My account</li>
    </ul>
	<h3> My Account</h3>	
	<hr class="soft">
	@if(Session::has('error'))
		<div class="alert alert-danger" role="alert">
			{{ Session::get('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	@if(Session::has('success'))
		<div class="alert alert-success" role="alert">
		    {{ Session::get('success') }}
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		        <span aria-hidden="true">&times;</span>
		    </button>
		</div>
	@endif
	
	<div class="row">
		<div class="span4">
			<div class="well">
			<h5>CONTACT DETAILS</h5><br>
			Enter your contact details.<br><br>
			<form id="accountForm" action="{{route('account')}}" method="post">@csrf
			  <div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
				  <input class="span3" type="text" id="name" name="name" placeholder="Enter Name" value="{{$user_details['name']}}" required="" pattern="[A-Za-z+]">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="address">Address</label>
				<div class="controls">
				  <input class="span3" type="text" id="address" name="address" placeholder="Enter Address" value="{{$user_details['address']}}">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="city">City</label>
				<div class="controls">
				  <input class="span3" type="text" id="city" name="city" placeholder="Enter City" value="{{$user_details['city']}}">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="state">State</label>
				<div class="controls">
				  <input class="span3" type="text" id="state" name="state" placeholder="Enter State" value="{{$user_details['state']}}">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="country">Country</label>
				<div class="controls">
				  <select class="span3" id="country" name="country">
				  	<option value="">Select Country</option>
				  	@foreach($countries as $country)
				  		<option value="{{ $country['country_name'] }}" @if($country['country_name']==$user_details['country']) selected="" @endif>{{ $country['country_name'] }}</option>
				  	@endforeach
				  </select>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="pincode">Pincode</label>
				<div class="controls">
				  <input class="span3" type="text" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{$user_details['pincode']}}">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="mobile">Mobile</label>
				<div class="controls">
				  <input class="span3" type="text" id="mobile" name="mobile" placeholder="Enter Mobile" value="{{$user_details['mobile']}}">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="email">Email</label>
				<div class="controls">
				  <input class="span3" readonly="" value="{{$user_details['email']}}">
				</div>
			  </div>

			  <div class="controls">
			  <button type="submit" class="btn block">Update</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>UPDATE PASSWORD</h5>
			<form id="passwordForm" action="{{url('/update-user-password')}}" method="post">@csrf

			  <div class="control-group">
				<label class="control-label" for="current_pwd">CurrentPassword</label>
				<div class="controls">
				  <input class="span3" type="password" id="current_pwd" name="current_pwd" placeholder="Current Password" required="">
				</div>
				<span id="checkCurrentPwd"></span>
			  </div>


			  <div class="control-group">
				<label class="control-label" for="new_pwd">New Password</label>
				<div class="controls">
				  <input class="span3" type="password" id="new_pwd" name="new_pwd" placeholder="New Password" required="">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="confirm_pwd">Confirm Password</label>
				<div class="controls">
				  <input class="span3" type="password" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password" required="">
				</div>
			  </div>

			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Update</button>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>

@endsection