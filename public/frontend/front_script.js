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
				$(".totalCartItems").html(resp.totalCartItems);
				$("#AppendCartItems").html(resp.view);
			},error:function(){
				alert("Error");
			}
		});
	});


	//Delete cart Items
	$(document).on('click','.btnItemDelete',function(){
		var cartid = $(this).data('cartid');
		var result = confirm("Want to delete this Cart Item");
		// alert(cartid); return flase;
		if (result) {
			$.ajax({
				data:{"cartid":cartid},
				url:'/delete-cart-item',
				type:'post',
				success:function(resp){
					$(".totalCartItems").html(resp.totalCartItems);
					$("#AppendCartItems").html(resp.view);
				},error:function(){
					alert("Error");
				}
			});
		}
	});

	// validate register form on keyup and submit
		$("#registerForm").validate({
			rules: {
				name: "required",
				mobile: {
					required: true,
					minlength: 11,
					maxlength: 11,
					digits: true
				},
				email: {
					required: true,
					email: true,
					remote: "check-email"
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				name: "Please enter your name",
				mobile: {
					required: "Please enter a Mobile",
					minlength: "Your Mobile must consist 11 digits",
					maxlength: "Your Mobile must consist 11 digits",
					digits: "please enter your valid Mobile"
				},
				email: {
					required: "please enter your Email",
					email: "please enter your valid Email",
					remote:"Email already exists!"
				},
				password: {
					required: "Please choose your password",
					minlength: "Your password must be at least 6 characters long"
				}
			}
		});

	// validate Login form on keyup and submit
		$("#loginForm").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				email: {
					required: "please enter your Email",
					email: "please enter your valid Email"
				},
				password: {
					required: "Please Enter your password",
					minlength: "Your password must be at least 6 characters long"
				}
			}
		});

	// validate user account form on keyup and submit
		$("#accountForm").validate({
			rules: {
				name: {
					required: true,
					lettersonly: true
				},
				mobile: {
					required: true,
					minlength: 11,
					maxlength: 11,
					digits: true
				}
			},
			messages: {
				name: {
					required: "Please enter your Name",
					lettersonly: "Please enter valid Name"
				},
				mobile: {
					required: "Please enter a Mobile",
					minlength: "Your Mobile must consist 11 digits",
					maxlength: "Your Mobile must consist 11 digits",
					digits: "please enter your valid Mobile"
				}
			}
		});	


	//Check User password is correct or not
	$("#current_pwd").keyup(function(){
		var current_pwd = $("#current_pwd").val();
		//alert(current_pwd);
		$.ajax({
			type : 'post',
			url: '/check-user-current-pwd',
			data: {current_pwd:current_pwd},
			success:function(resp){
				//alert(resp);
				if (resp=="false") {
					$("#checkCurrentPwd").html("<font color=red>Current Password is incorrect</font>");
				}else if(resp=="true"){
					$("#checkCurrentPwd").html("<font color=green>Current Password is correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});
	//End Check user password is correct or not	

	// validate password update form on keyup and submit
		$("#passwordForm").validate({
			rules: {
				current_pwd: {
					required: true,
					minlength: 6,
					maxlength: 20
				},
				new_pwd: {
					required: true,
					minlength: 6,
					maxlength: 20
				},
				confirm_pwd: {
					required: true,
					minlength: 6,
					maxlength: 20,
					equalTo:"#new_pwd"
				}
			},
			messages: {
				current_pwd: {
					required: "Please choose your Current password",
					minlength: "Your password must be at least 6 characters long",
					maxlength: "Your password must be at least 20 characters long"
				},
				new_pwd: {
					required: "Please choose your New password",
					minlength: "Your password must be at least 6 characters long",
					maxlength: "Your password must be at least 20 characters long"
				},
				confirm_pwd: {
					required: "Please choose your Confirm password",
					minlength: "Your password must be at least 6 characters long",
					maxlength: "Your password must be at least 20 characters long",
					equalTo: "New & Confirm Password Must be same"
				}
			}
		});	



});