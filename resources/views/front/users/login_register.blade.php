@extends('layouts.front_layouts.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Login</li>
    </ul>
	<h3> Login / Register</h3>	
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
			<h5>CREATE YOUR ACCOUNT</h5><br>
			Enter your details to create an account.<br><br>
			<form id="registerForm" action="{{route('register')}}" method="post">@csrf
			  <div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
				  <input class="span3" type="text" id="name" name="name" placeholder="Enter Name">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="mobile">Mobile</label>
				<div class="controls">
				  <input class="span3" type="text" id="mobile" name="mobile" placeholder="Enter Mobile">
				</div>
			  </div>

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

			  <div class="controls">
			  <button type="submit" class="btn block">Create Your Account</button>
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
				  <button type="submit" class="btn">Sign in</button> <a href="forgetpass.html">Forget password?</a>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>

@endsection