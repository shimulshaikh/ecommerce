<?php use App\Product; ?>
@extends('layouts.front_layouts.front_layout')
@section('content')

		<div class="span9">
				<div class="well well-small">
					<h4>Featured Products <small class="pull-right">{{$featureItemsCount}} featured products</small></h4>
					<div class="row-fluid">
						<div id="featured" @if($featureItemsCount>4) class="carousel slide" @endif>
							<div class="carousel-inner">
								@foreach($featureItemsChunk as $key=>$featureItem)
								<div class="item @if($key==1) active @endif">
									<ul class="thumbnails">
										@foreach($featureItem as $item)	
										<li class="span3">
											<div class="thumbnail">
												<?php $discountPrice=Product::getDiscountPrice($item['id'])?>
												<i class="tag"></i>
												<a href="{{ url('/product/'.$item['id']) }}">
												@if(!empty($item['main_image']))	
													<img src="{{ asset('/storage/product/small') }}/{{ $item['main_image'] }}" alt="">
												@else
							                        <img src="{{asset('backend/dist/img/No_Image.jpg')}}">
							                    @endif
                  								</a>
												<div class="caption">
													<h5>{{$item['product_name']}}</h5>
													<h4><a class="btn" href="{{ url('/product/'.$item['id']) }}">VIEW</a> <span class="pull-right" style="font-size: 12px;">
														@if($discountPrice>0)	
															<del>Rs.{{$item['product_price']}}</del>
															<font color="red">Rs.{{$discountPrice}}</font>
														@else
															Rs.{{$item['product_price']}}
														@endif	
													</span></h4>
												</div>
											</div>
										</li>
										@endforeach
									</ul>
								</div>
								@endforeach
							</div>
							<a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
							<a class="right carousel-control" href="#featured" data-slide="next">›</a>
						</div>
					</div>
				</div>
				<h4>Latest Products </h4>
				<ul class="thumbnails">
					@foreach($newProducts as $product)
					<li class="span3">
						<div class="thumbnail">
							<?php $discountPrice=Product::getDiscountPrice($product['id'])?>
							<a  href="{{ url('/product/'.$product['id']) }}">
								@if(!empty($product->main_image))	
									<img style="width: 160px;" src="{{ asset('/storage/product/small') }}/{{ $product->main_image }}" alt="">
								@else
							        <img style="width: 160px;" src="{{asset('backend/dist/img/No_Image.jpg')}}">
							    @endif
							</a>
							<div class="caption" style="height: 180px;">
								<h5>{{$product->product_name}}</h5>
								<p>
									{{$product->product_code}}-{{$product->product_color}}
								</p>
								
								<h4 style="text-align:center"> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">@if($discountPrice>0)	
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
			</div>
@endsection  			