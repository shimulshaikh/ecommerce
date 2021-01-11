$(document).ready(function(){

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   	 }
	});


	/*$("#sort").on('change',function(){
		this.form.submit();
	}); */

	//Sort product
	$("#sort").on('change',function(){
		var sort = $(this).val();
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occasion = get_filter('occasion');
		var url = $("#url").val();
		
		$.ajax({
			url:url,
			method : "post",
			data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion:occasion,sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		});
	});	

	$(".fabric").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occasion = get_filter('occasion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method : "post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion:occasion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});

	});

	$(".sleeve").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occasion = get_filter('occasion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method : "post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion:occasion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});

	});

	$(".pattern").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occasion = get_filter('occasion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method : "post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion:occasion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});

	});

	$(".fit").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occasion = get_filter('occasion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method : "post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion:occasion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});

	});

	$(".occasion").on('click',function(){
		var fabric = get_filter('fabric');
		var sleeve = get_filter('sleeve');
		var pattern = get_filter('pattern');
		var fit = get_filter('fit');
		var occasion = get_filter('occasion');
		var sort = $("#sort option:selected").val();
		var url = $("#url").val();
			$.ajax({
				url:url,
				method : "post",
				data: {fabric:fabric,sleeve:sleeve,pattern:pattern,fit:fit,occasion:occasion,sort:sort,url:url},
				success:function(data){
					$('.filter_products').html(data);
				}
			});

	});

	function get_filter(class_name){
		var filer = [];
		$('.'+class_name+':checked').each(function(){
			filer.push($(this).val());
		});
		return filer;
	}

	//size get product price
	$("#getPrice").change(function(){
		var size = $(this).val();
		if (size=="") {
			alert("Please select Size");
			return false;
		}
		var product_id = $(this).attr('product-id');
		$.ajax({
			url:'/get-product-price',
			data: {size:size,product_id:product_id},
			type: 'post',
			success:function(resp){
				// alert(resp['product_price']);
				// alert(resp['discount_price']);
				// return false;
				if(resp['discount_price']>0){
					$(".getAttrPrice").html("<del>Rs. "+resp['product_price']+"</del> Rs."+resp['discount_price']);
				}else{
					$(".getAttrPrice").html("Rs. "+resp['product_price']);
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Update cart Items
	$(document).on('click','.btnItemUpdate',function(){
		if($(this).hasClass('qtyMinus')){
			var quantity = $(this).prev().val();
			//alert(quantity);
			//If qtyMinus button gets clicked by User
			if (quantity<=1) {
				alert("Item quantity must be 1 or greater!");
				return false;
			}else{
				new_qty = parseInt(quantity)-1;
			}
		}
		if($(this).hasClass('qtyPlus')){
			//If qtyPlus button gets clicked by User
			var quantity = $(this).prev().prev().val();
			new_qty = parseInt(quantity)+1;
		}
	 	//alert(new_qty);
		var cartid = $(this).data('cartid');
		//alert(cartid);
		$.ajax({
			data:{"cartid":cartid,"qty":new_qty},
			url:'/update-cart-item-qty',
			type:'post',
			success:function(resp){
				// alert(resp.status);
				if (resp.status==false) {
					alert(resp.message);
				}
				$("#AppendCartItems").html(resp.view);
			},error:function(){
				alert("Error");
			}
		});
	});




});