$(document).ready(function(){
	//Check Admin password is correct or not
	$("#current_pwd").keyup(function(){
		var current_pwd = $("#current_pwd").val();
		//alert(current_pwd);
		$.ajax({
			type : 'post',
			url: '/admin/check-current-pwd',
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
	//End Check Admin password is correct or not

	//update section status
	$(document).on("click",".updateSectionStatus",function(){	
		var status = $(this).children("i").attr("status");
		var section_id = $(this).attr("section_id");
		// alert(status);
		// alert(section_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-section-status',
			data : {status:status, section_id:section_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['section_id']);
				if(resp['status']==0){
					$("#section-"+section_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#section-"+section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//update category status
	$(document).on("click",".updateCategoryStatus",function(){	
		var status = $(this).children("i").attr("status");
		var category_id = $(this).attr("category_id");
		// alert(status);
		// alert(category_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-category-status',
			data : {status:status, category_id:category_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['category_id']);
				if(resp['status']==0){
					$("#category-"+category_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#category-"+category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//Append Categoris level
	$('#section_id').change(function(){
		var section_id = $(this).val();
		//alert(section_id);
		$.ajax({
			type: 'post',
			url: '/admin/append-categories-level',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategorisLevel").html(resp);
			},error:function(){
				alert("Error");
			}
		});
	});


	//update product status
	$(document).on("click",".updateProductStatus",function(){	
		var status = $(this).children("i").attr("status");
		var product_id = $(this).attr("product_id");
		// alert(status);
		// alert(product_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-product-status',
			data : {status:status, product_id:product_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['product_id']);
				if(resp['status']==0){
					$("#product-"+product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#product-"+product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//products attributes Add/Remove script
	var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" style="width:100px" value="" placeholder="size" required=""/>&nbsp;<input type="text" name="sku[]" style="width:100px" value="" placeholder="sku" required=""/>&nbsp;<input type="number" min="0" name="price[]" style="width:100px" value="" placeholder="price" required=""/>&nbsp;<input type="number" min="0" name="stock[]" style="width:100px" value="" placeholder="stock" required=""/><a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    //update product attributes status
	$(document).on("click",".updateAttributesStatus",function(){	
		var status = $(this).text();
		var attribute_id = $(this).attr("attribute_id");
		// alert(status);
		// alert(attribute_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-attribute-status',
			data : {status:status, attribute_id:attribute_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['attribute_id']);
				if(resp['status']==0){
					$("#attribute-"+attribute_id).html("<a class='updateAttributesStatus' href='javascript:void(0)'>Inactive</a>");
				}else if(resp['status']==1){
					$("#attribute-"+attribute_id).html("<a class='updateAttributesStatus' href='javascript:void(0)'>Active</a>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//update product Images status
	$(document).on("click",".updateImageStatus",function(){		
		var status = $(this).text();
		var images_id = $(this).attr("images_id");
		// alert(status);
		// alert(images_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-images-status',
			data : {status:status, images_id:images_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['images_id']);
				if(resp['status']==0){
					$("#images-"+images_id).html("<a class='updateImageStatus' href='javascript:void(0)'>Inactive</a>");
				}else if(resp['status']==1){
					$("#images-"+images_id).html("<a class='updateImageStatus' href='javascript:void(0)'>Active</a>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//update brand status
	$(document).on("click",".updateBrandStatus",function(){	
		var status = $(this).children("i").attr("status");
		var brand_id = $(this).attr("brand_id");
		// alert(status);
		// alert(brand_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-brand-status',
			data : {status:status, brand_id:brand_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['brand_id']);
				if(resp['status']==0){
					$("#brand-"+brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#brand-"+brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//update banner status
	$(document).on("click",".updateBannerStatus",function(){	
		var status = $(this).children("i").attr("status");
		var banner_id = $(this).attr("banner_id");
		//alert(status);
		// alert(banner_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-banner-status',
			data : {status:status, banner_id:banner_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['banner_id']);
				if(resp['status']==0){
					$("#banner-"+banner_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#banner-"+banner_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});


	//update coupon status
	$(document).on("click",".updateCouponStatus",function(){	
		var status = $(this).children("i").attr("status");
		var coupon_id = $(this).attr("coupon_id");
		// alert(status);
		// alert(coupon_id);
		$.ajax({
			type : 'post',
			url : '/admin/update-coupon-status',
			data : {status:status, coupon_id:coupon_id},
			success:function(resp){
				// alert(resp['status']);
				// alert(resp['coupon_id']);
				if(resp['status']==0){
					$("#coupon-"+coupon_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#coupon-"+coupon_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//show/Hide Coupon Field for Manual/Automatic
	$("#ManualCoupon").click(function(){
		$("#couponField").show();
	});

	$("#AutomaticCoupon").click(function(){
		$("#couponField").hide();
	});

	//Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //show courier name name And tracking number in case of Shipping oder status
    $('#courier_name').hide();
    $('#tracking_number').hide();

    $('#order_status').on('change', function(){
    	// alert(this.value);
    	if (this.value == "Shippen") {
    		$('#courier_name').show();
    		$('#tracking_number').show();
    	}else{
    		$('#courier_name').hide();
    		$('#tracking_number').hide();	
    	}
    });

});