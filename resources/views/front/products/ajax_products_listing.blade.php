<?php use App\Product; ?>
<div class="tab-pane  active" id="blockView">
					<ul class="thumbnails">
						@foreach($categoryProducts as $product)
						<li class="span3">
							<div class="thumbnail" style="height: 420px;">
								<a href="{{ url('/product/'.$product['id']) }}">
									@if(!empty($product['main_image']))	
										<img src="{{ asset('/storage/product/small') }}/{{ $product['main_image'] }}" alt="">
									@else
							            <img src="{{asset('backend/dist/img/No_Image.jpg')}}">
							        @endif
								</a>
								<div class="caption">
									<h5>{{$product['product_name']}}</h5>
									<p>
										{{$product['brand']['name']}}
									</p>
									
									<?php $discountPrice=Product::getDiscountPrice($product['id'])?>

									<h4 style="text-align:center"><!-- <a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> --> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">
									@if($discountPrice>0)	
										<del>Rs.{{$product['product_price']}}</del>
										<font color="yellow">Rs.{{$discountPrice}}</font>
									@else
										Rs.{{$product['product_price']}}
									@endif	
									</a></h4>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
					<hr class="soft">
				</div>