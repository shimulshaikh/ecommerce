<div class="tab-pane  active" id="blockView">
					<ul class="thumbnails">
						@foreach($categoryProducts as $product)
						<li class="span3">
							<div class="thumbnail">
								<a href="product_details.html">
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
									<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{$product['product_price']}}</a></h4>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
					<hr class="soft">
				</div>