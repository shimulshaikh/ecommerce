

@extends('layouts.front_layouts.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active"> SHOPPING CART</li>
    </ul>
	<h3>  SHOPPING CART [ <small><span class="totalCartItems"> {{ totalCartItems() }} </span> Item(s) </small>]<a href="{{ url('/') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>	
	<hr class="soft">

					@if(Session::has('error'))
				      <div class="alert alert-danger" role="alert">
				        {{ Session::get('error') }}
				        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      @php Session::forget('error') @endphp
				    @endif
				    @if(Session::has('success'))
		                <div class="alert alert-success" role="alert">
		                  {{ Session::get('success') }}
		                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                  </button>
		                </div>
		                @php Session::forget('success') @endphp
		            @endif	
	
	<div id="AppendCartItems">		
		@include('front.products.cart_items')
	</div>
		
		
            <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td> 
				<form id="applyCoupon" action="javascript:void(0);" method="post" class="form-horizontal" @if(Auth::check()) user="1" @endif>@csrf
				<div class="control-group">
				<label class="control-label"><strong> COUPON CODE: </strong> </label>
				<div class="controls">
				<input type="text" name="code" id="code" class="input-medium" placeholder="Enter Coupon Code" required="">
				<button type="submit" class="btn"> APPLY </button>
				</div>
				</div>
				</form>
				</td>
                </tr>
				
			</tbody>
			</table>
			
					
	<a href="{{ url('/') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
	<a href="{{ url('checkout') }}" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>
	
</div>

@endsection