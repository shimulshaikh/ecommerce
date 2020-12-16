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

});