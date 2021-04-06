<?php 
	// use App\Cart;
	use App\Product;
?>

<table class="table table-bordered">
	              <thead>
	                <tr>
	                  <th>Product</th>
	                  <th colspan="2">Description</th>
	                  <th>Quantity/Update</th>
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
					  <td>
						<div class="input-append">
							<input class="span1" style="max-width:34px" value="{{$item['quantity']}}" id="appendedInputButtons" size="16" type="text">
							<button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{$item['id']}}"><i class="icon-minus"></i></button>
							<button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{$item['id']}}"><i class="icon-plus"></i></button>
							<button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{$item['id']}}"><i class="icon-remove icon-white"></i></button>				
						</div>
					  </td>
	                  <td>Rs.{{$attrPrice['product_price']*$item['quantity']}}</td>
	                  <td>Rs.{{$attrPrice['discount']*$item['quantity']}}</td>
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
	                  <td class="label label-important" style="display:block"> <strong class="grand_total"> Rs.{{$total_price - Session::get('couponAmount') }} </strong></td>
	                </tr>
					</tbody>
	    </table>