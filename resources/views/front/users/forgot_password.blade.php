@extends('layouts.front_layouts.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Forgot Password</li>
    </ul>
	<h3> Forgot Password</h3>	
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
			<h5>Forgot Password</h5><br>
			Enter your email to get the new password.<br><br>
			<form action="{{url('/forgot-password')}}" method="post">@csrf

			  <div class="control-group">
				<label class="control-label" for="email">E-mail address</label>
				<div class="controls">
				  <input class="span3" type="text" id="email" name="email" placeholder="Email" required="">
				</div>
			  </div>

			  <div class="controls">
			  <button type="submit" class="btn block">Submit</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>ALREADY REGISTERED ?</h5>
			<form id="loginForm" action="{{route('loginUser')}}" method="post">@csrf
			  <div class="control-group">
				<label class="control-label" for="email">E-mail address</label>
				<div class="controls">
				  <input class="span3" type="text" id="email" name="email" placeholder="Email">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
				  <input class="span3" type="text" id="password" name="password" placeholder="Password">
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Sign in</button> <a href="{{url('forgot-password')}}">Forgot password?</a>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>

@endsection