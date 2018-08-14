jQuery(document).ready(function() {

jQuery("#check_all").on('click',function(){
	   if(jQuery(".checkbox_id").prop("checked")) {
	           jQuery(this).html('<span class="oi oi-check"></span> Check');
			   jQuery(".checkbox_id").prop('checked', false);
            } else {
	           jQuery(this).html('<span class="oi oi-x"></span> Uncheck');
	           jQuery(".checkbox_id").prop('checked', true);
            }
});

 var  testimonial_table =	jQuery('#msg-table').DataTable({
"order": [[ 0, "desc" ]],
"processing": true,
"serverSide": true,
"ajax": {
			"url": ajaxurl+'?action=whook_test_table',
			"data": function ( d ) {
				d.msg_status = jQuery("#msg_status").val();
			 }
		}
});

jQuery('#msg_status').on('change', function() {
   testimonial_table.draw();
});

 var  question_table =	jQuery('#question-table-list').DataTable( {
	"order": [[ 0, "desc" ]],
	"processing": true,
	"serverSide": true,
	"ajax": {
			"url": ajaxurl+'?action=whook_test_question_table_list',
			"data": function ( d ) {
				d.question_status = jQuery("#question_status").val();
			 }
		}
 });

jQuery('#question_status').on('change', function() {
   question_table.draw();
});

jQuery(document).on('click','.msg-delete-btn',function(){

var frm_data = jQuery(".table-frm").serialize();

   var yourArray = [];
        var i=0;
        jQuery("input:checkbox[name='id[]']:checked").each(function(){
            yourArray[i] = jQuery(this).val();
            i++;
        });
        
        if(typeof(yourArray[0])=="undefined")
        {
            swal("Sorry!", "Please choose first", "warning");
            return false;
        }


        swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Delete it!',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false
},function(){

jQuery(".preload_area").show();


jQuery.ajax({
				type: "POST",
				url: ajaxurl+'?action=whook_test_delete_testimonial',
				data: frm_data,
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#test").html(result);

					if(result=="success")
					{
		 	          	 swal({title: "Delete!",
			                  text: "Successfully Delete.",
							  type: "success",},function(){
								testimonial_table.draw();
						      });  
							  
					}
					//jQuery("#test").html(result);
				}
       });	

       });
	   
 });	

jQuery(document).on('click','.ques-delete-btn',function(){

var frm_data = jQuery(".table-frm").serialize();

   var yourArray = [];
        var i=0;
        jQuery("input:checkbox[name='id[]']:checked").each(function(){
            yourArray[i] = jQuery(this).val();
            i++;
        });
        
        if(typeof(yourArray[0])=="undefined")
        {
            swal("Sorry!", "Please choose first", "warning");
            return false;
        }


        swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Delete it!',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false
},function(){

jQuery(".preload_area").show();


jQuery.ajax({
				type: "POST",
				url: ajaxurl+'?action=whook_test_delete_question',
				data: frm_data,
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#test").html(result);

					if(result=="success")
					{
		 	          	 swal({title: "Delete!",
			                  text: "Successfully Delete.",
							  type: "success",},function(){
								question_table.draw();
						      });  
							  
					}
					//jQuery("#test").html(result);
				}
       });	

       });
	   
 });	

jQuery(document).on('click','.msg-edit-btn',function(){
jQuery(".preload_area").show();

var id = jQuery(this).data("id");

jQuery.ajax({
				type: "POST",
				url: ajaxurl+'?action=whook_test_update_frm',
				data: {"id":id},
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					jQuery("#msg-edit").html(result);
					jQuery('#popup-msg').modal('show');
					//jQuery("#test").html(result);

					if(result=="success")
					{
		 	          	  
							  
					}else if(result=="error")
					{
		 	                   swal("Sorry!", "Fail to get testimonial", "error");
					}
					//jQuery("#test").html(result);
				}
       });	

       });	


jQuery(document).on('click','.question-edit-btn, .ques-addnew-btn',function(){
jQuery(".preload_area").show();

var id = jQuery(this).data("id");

jQuery.ajax({
				type: "POST",
				url: ajaxurl+'?action=whook_test_whook_test_question_updatefrm',
				data: {"id":id},
				cache:false,
				dataType: "html",
				success: function(result){
					<!--alert(result);-->
					jQuery(".preload_area").hide();
					jQuery("#question-edit-frm").html(result);
					jQuery('#popup-msg').modal('show');
					//jQuery("#test").html(result);
				}
       });	

       });	
	   
	   


jQuery(document).on('click','#msg-submit-btn',function(){
jQuery(".preload_area").show();

		var frm_data = jQuery("#msg-frm").serialize();

jQuery.ajax({
				type: "POST",
				url: ajaxurl+'?action=whook_test_update_testimonial',
				data: frm_data,
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#msg-edit").html(result);
					jQuery('#popup-msg').modal('hide');
					
					if(result=="success")
					{
		 	          	  swal({title: "Update!",
			                  text: "Successfully Update.",
							  type: "success",},function(){
								testimonial_table.draw();
							  //window.location.href="";
						      });
							  
					}else if(result=="error")
					{
		 	                  swal("Sorry!", "Fail to update", "error");
					}
				}
       });	

       });
	

	
jQuery(document).on('click','#delete-img',function(){
jQuery(".preload_area").show();

var img = jQuery(this).data("img");
var msg_id = jQuery('#msg_id').val();

jQuery.ajax({
				type: "POST",
				url: ajaxurl+"?action=whook_delete_image",
				data: {"img":img,"msg_id":msg_id},
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#msg-edit").html(result);
					if(result=="error")
					{
						jQuery("#whook_delete_image").html(result);
					}else
					{
						jQuery("#whook_delete_image").html(result);
					}
				}
       });	

       });	
	   
	   
	   
	<!-- question update command -->   
	   
	   
jQuery(document).on('click','#question-update-btn',function(){

jQuery(".preload_area").show();
var frm_data = jQuery("#question-frm").serialize();

jQuery.ajax({
				type: "POST",
				url: ajaxurl+"?action=whook_test_question_update",
				data: frm_data,
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#msg-edit").html(result);
					jQuery('#popup-msg').modal('hide');
					
					if(result=="success")
					{
		 	          	  swal({title: "Update!",
			                  text: "Successfully Update.",
							  type: "success",},function(){
							    question_table.draw();
						      });
							  
					}else if(result=="error")
					{
		 	                  swal("Sorry!", "Fail to update", "error");
					}
				}
       });	
       });
	   
	
jQuery(document).on('click','#question-add-btn',function(){

jQuery(".preload_area").show();
var frm_data = jQuery("#question-frm").serialize();

jQuery.ajax({
				type: "POST",
				url: ajaxurl+"?action=whook_test_question_add",
				data: frm_data,
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#msg-edit").html(result);
					jQuery('#popup-msg').modal('hide');
					
					if(result=="success")
					{
		 	          	  swal({title: "Update!",
			                  text: "Successfully Add New.",
							  type: "success",},function(){
							    question_table.draw();
						      });
							  
					}else if(result=="error")
					{
		 	                  swal("Sorry!", "Fail to update", "error");
					}
				}
       });	
       });
	   	
	   
	   <!-- question update command -->  
	   
	
jQuery(document).on('click','#btn-setting',function(e){
e.preventDefault();
jQuery(".preload_area").show();
var frm_data = jQuery(".valid-frm").serialize();

jQuery.ajax({
				type: "POST",
				url: ajaxurl+"?action=whook_test_setting_update",
				data: frm_data,
				cache:false,
				dataType: "html",
				success: function(result){
					jQuery(".preload_area").hide();
					//jQuery("#msg-edit").html(result);
					console.log(result);
					jQuery('#popup-msg').modal('hide');

					if(result=="success")
					{
		 	          	  swal({title: "Update!",
			                  text: "Successfully Update.",
							  type: "success",},function(){
							    window.location.href="";
						      });
							  
					}else if(result=="error")
					{
		 	                  swal("Sorry!", "Fail to update", "error");
					}
				}
       });	

       });
	   
	
} );
