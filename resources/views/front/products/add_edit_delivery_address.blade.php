@extends('layouts.front_layouts.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Delivery Address</li>
    </ul>
	<h3> {{ $title }}</h3>	
	<hr class="soft">

	@if ($errors->any())
        <div class="alert alert-danger" style="margin-top: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

	@if(Session::has('error'))
		<div class="alert alert-danger" role="alert">
			{{ Session::get('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php Session::forget('error'); ?>
	@endif
	@if(Session::has('success'))
		<div class="alert alert-success" role="alert">
		    {{ Session::get('success') }}
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		        <span aria-hidden="true">&times;</span>
		    </button>
		</div>
		<?php Session::forget('success'); ?>
	@endif
	
	<div class="row">
		<div class="span4">
			<div class="well">
			Enter your delivery address details.<br><br>
			<form id="deliveryAddressForm" @if(empty($address['id'])) action="{{url('/add-edit-delivery-address')}}" @else action="{{url('/add-edit-delivery-address/'.$address['id'])}}" @endif method="post">@csrf
			  <div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
				  <input class="span3" type="text" id="name" name="name" placeholder="Enter Name" required="" @if(isset($address['name'])) value="{{ $address['name'] }}" @else value="{{ old('name') }}" @endif>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="address">Address</label>
				<div class="controls">
				  <input class="span3" type="text" id="address" name="address" placeholder="Enter Address" @if(isset($address['address'])) value="{{ $address['address'] }}" @else value="{{ old('address') }}" @endif>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="city">City</label>
				<div class="controls">
				  <input class="span3" type="text" id="city" name="city" placeholder="Enter City" @if(isset($address['city'])) value="{{ $address['city'] }}" @else value="{{ old('city') }}" @endif>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="state">State</label>
				<div class="controls">
				  <input class="span3" type="text" id="state" name="state" placeholder="Enter State" @if(isset($address['state'])) value="{{ $address['state'] }}" @else value="{{ old('state') }}" @endif>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="country">Country</label>
				<div class="controls">
				  <select class="span3" id="country" name="country">
				  	<option value="">Select Country</option>
				  	@foreach($countries as $country)
				  		<option @if($country['country_name'] == $address['country']) selected="" @endif value="{{ $country['country_name'] }}">{{ $country['country_name'] }}</option>
				  	@endforeach
				  </select>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="pincode">Pincode</label>
				<div class="controls">
				  <input class="span3" type="text" id="pincode" name="pincode" placeholder="Enter Pincode" @if(isset($address['pincode'])) value="{{ $address['pincode'] }}" @else value="{{ old('pincode') }}" @endif>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="mobile">Mobile</label>
				<div class="controls">
				  <input class="span3" type="text" id="mobile" name="mobile" placeholder="Enter Mobile" @if(isset($address['mobile'])) value="{{ $address['mobile'] }}" @else value="{{ old('mobile') }}" @endif>
				</div>
			  </div>

			  <div class="controls">
			  <button type="submit" class="btn block">Submit</button>
			  <a style="float: right;" class="btn block" href="{{ url('/checkout') }}">Back</a>
			  </div>
			</form>
		</div>
		</div>
	
	</div>	
	
</div>

@endsection