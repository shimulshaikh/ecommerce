<!DOCTYPE html>
<html>

<body style="width: 700px;">
<table>	
	<tr><td>&nbsp;</td></tr>
	<tr><td><img src="{{asset('frontend/themes/images/ico-cart.png')}}"></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Hello {{ $name }},</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Thank you for shopping with us. Your order details are as bellow :-</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Order No: {{ $order_id }}</td></tr>
	<tr>
		<td>
			<table style="width: 95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
				<tr bgcolor="#cccccc">
					<td>product Name :</td>
					<td>product Code :</td>
					<td>product Size :</td>
					<td>product Color :</td>
					<td>product Quantity :</td>
					<td>product Price :</td>
				</tr>
				@foreach($orderDetails['orders_product'] as $order)
					<tr>
						<td>{{ $order['product_name'] }}</td>
						<td>{{ $order['product_code'] }}</td>
						<td>{{ $order['product_size'] }}</td>
						<td>{{ $order['product_color'] }}</td>
						<td>{{ $order['product_qty'] }}</td>
						<td>{{ $order['product_price'] }}</td>
					</tr>
				@endforeach
					<tr>
						<td colspan="5" align="right">Shipping Charges</td>
						<td>TK : {{ $orderDetails['shipping_charges'] }}</td>
					</tr>
					<tr>
						<td colspan="5" align="right">Coupon Discount</td>
						<td>
							TK : 
							@if($orderDetails['coupon_amount'] > 0)
								{{ $orderDetails['coupon_amount'] }}
							@else
								0
							@endif		
						</td>
					</tr>
					<tr>
						<td colspan="5" align="right">Grand Total</td>
						<td>TK : {{ $orderDetails['grand_total'] }}</td>
					</tr>
			</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			<table>
				<tr>
					<td><strong>Delivery Address :</strong></td>
				</tr>
				<tr>
					<td>{{ $orderDetails['name'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['address'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['city'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['country'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['pincode'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['mobile'] }}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>For any enquiries, you can contact us at <a href="mojarshop@gmail.com">mojarshop@gmail.com</a></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Regards,<br>Mojar Shopping</td></tr>
	<tr><td>&nbsp;</td></tr>
</table>	
</body>

</html>