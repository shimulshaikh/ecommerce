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
	$(".updateSectionStatus").click(function(){
		var status = $(this).text();
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
					$("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Inactive</a>");
				}else if(resp['status']==1){
					$("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Active</a>");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});

	//update category status
	$(".updateCategoryStatus").click(function(){
		var status = $(this).text();
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
					$("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>");
				}else if(resp['status']==1){
					$("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Active</a>");	
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
	$(".updateProductStatus").click(function(){
		var status = $(this).text();
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
					$("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Inactive</a>");
				}else if(resp['status']==1){
					$("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Active</a>");	
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
	$(".updateAttributesStatus").click(function(){
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
					$("#attribute-"+attribute_id).html("Inactive");
				}else if(resp['status']==1){
					$("#attribute-"+attribute_id).html("Active");	
				}
			},error:function(){
				alert('Error');
			}
		});
	});


});