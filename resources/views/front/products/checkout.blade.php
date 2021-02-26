<?php 
	use App\Product;
?>

@extends('layouts.front_layouts.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active"> CHECKOUT</li>
    </ul>
	<h3>  CHECKOUT [ <small><span class="totalCartItems"> {{ totalCartItems() }} </span> Item(s) </small>]<a href="{{ url('/cart') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Back to Cart </a></h3>	
	<hr class="soft">

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

<form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">
	@csrf
	
	<table class="table table-bordered">
		<tr><th> <strong>DELIVERY ADDRESSES</strong> | <a href="{{url('/add-edit-delivery-address')}}">Add</a>  </th></tr>
		 @foreach($deliveryAddresse as $address)
		 <tr> 
		 	<td>
				<div class="control-group" style="float: left; margin-top: -2px; margin-right: 5px;">
					<input type="radio" id="address{{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}">
				</div>

				<div class="control-group">
				  <label class="control-label">{{ $address['name'] }},{{ $address['address'] }},{{ $address['city'] }},{{ $address['state'] }},{{ $address['country'] }},{{ $address['mobile'] }}</label>
				</div>
		  	</td>
		  	<td><a href="{{ url('/add-edit-delivery-address/'.$address['id']) }}">Edit</a> | <a href="{{ url('/delete-delivery-address/'.$address['id']) }}" onclick="return confirm('Are You sure want to delete !')">Delete</a></td>
		  </tr>
		  @endforeach
	</table>

	<table class="table table-bordered">
	              <thead>
	                <tr>
	                  <th>Product</th>
	                  <th colspan="2">Description</th>
	                  <th>Quantity</th>
					  <th>MRP</th>
	                  <th>Category/Product <br/>Discount</th>
	                  <th>Sub Total</th>
					</tr>
	              </thead>
	              <tbody>
	              	<?php $total_price=0;?>
	              	@foreach($userCartItems as $item)
	              	<?php $attrPrice=Product::getDiscountAttriPrice($item['product_id'],$item['size']) ?>
	                <tr>
	                  <td> <img width="60" src="{{ asset('/storage/product/large') }}/{{ $item['product']['main_image']  }}" alt="">
	                  </td>
	                  <td  colspan="2">{{$item['product']['product_name']}}({{$item['product']['product_code']}})<br>
	                  	Color : {{$item['product']['product_color']}}<br>
	                  	Size : {{$item['size']}}
	                  </td>
					  <td>{{$item['quantity']}}</td>
	                  <td>Rs.{{$attrPrice['product_price']}}</td>
	                  <td>Rs.{{$attrPrice['discount']}}</td>
	                  <td>Rs.{{$attrPrice['discount_price']*$item['quantity']}}</td>
	                </tr>
	                <?php $total_price=$total_price+ ($attrPrice['discount_price']*$item['quantity'])?>
	                @endforeach
					
	                <tr>
	                  <td colspan="6" style="text-align:right">Sub Total:	</td>
	                  <td> Rs.{{$total_price}}</td>
	                </tr>
					 <tr>
	                  <td colspan="6" style="text-align:right">Coupon Discount:	</td>
	                  <td class="couponAmount">
	                  	 @if(Session::has('couponAmount'))
	                  	 	- Rs. {{ Session::get('couponAmount') }}
	                  	 @else
	                  	 	Rs. 0
	                  	 @endif		
	                  </td>
	                </tr>
	                 <tr>
	                </tr>
					 <tr>
	                  <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (Rs.{{$total_price}} - <span class="couponAmount">Rs.0</span>) =</strong></td>
	                  <td class="label label-important" style="display:block"> <strong class="grand_total"> Rs.{{ $grand_total = $total_price - Session::get('couponAmount') }}
	                  	<?php Session::put('grand_total',$grand_total); ?>
	                   </strong></td>
	                </tr>
					</tbody>
	</table>
		
		
            <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td> 
					<div class="control-group">
					<label class="control-label"><strong> PAYMENT METHODS: </strong> </label>
						<div class="controls">
							<span>
								<input type="radio" name="payment_gateway" id="COD" value="COD"><strong>COD</strong>&nbsp;&nbsp;
								<input type="radio" name="payment_gateway" id="Paypal" value="Paypal"><strong>Paypal</strong>
							</span>
						</div>
					</div>
				</td>
                </tr>
				
			</tbody>
			</table>
			
					
	<a href="{{ url('/cart') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to Cart </a>
	<button type="submit" class="btn btn-large pull-right">Place Order <i class="icon-arrow-right"></i></button>
</form>	
</div>

@endsection