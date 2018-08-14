jQuery(document).ready(function(){

jQuery("#msg-frm").submit(function(e) {
    e.preventDefault();
}).validate({
ignore: [],
rules: {
'hidden-grecaptcha':{
             required: true   
          }
},
rules: {
		file:{
				extension: "jpg|jpeg|png"
},				},
	   submitHandler: function(form) {
		jQuery("#ajax-loader").show();
		var frm_data = new FormData(form);
        jQuery.ajax({
		  type:'POST',	
          url: whook_test_site_url+'/wp-admin/admin-ajax.php?action=whook_test_submit_form',
		  data: frm_data,
		  cache:false,
		  contentType:false,
		  processData:false,
		  enctype: 'multipart/form-data',
          success: function(result) {
			  console.log(result);
			if(result=="success")
			{  
               jQuery("#msg-frm")[0].reset();
			   jQuery('.jpreview-image').remove();
			   swal('Successfully!','Sent Message','success');
			   	if(typeof(grecaptcha)!='undefined')
	            {
			      grecaptcha.reset();
				}
			}else if(result=='InvalidCaptch')
			{
               swal('Sorry!','Please Verify Recaptch','warning');
			}else
			{
               swal('Error!','Sent Message','error');
			}
	        jQuery("#ajax-loader").hide();
			jQuery('.uploadifive-button').addClass('success-upload'); 
          }
        });
		//return false; 
	   }

});

jQuery(document).on('click','#btn-load-more',function(){

jQuery("#ajax-loader").show();

        start_limit = jQuery("#hid_start_limit").val();
        end_limit = jQuery("#hid_end_limit").val();
		   
        jQuery.ajax({
		  type:'POST',	
          url: whook_test_site_url+'/wp-admin/admin-ajax.php?action=whook_test_load_more_feedback',
		  data:{"start_limit":start_limit,"end_limit":end_limit},
		  cache:false,
		  dataType: "html",
          success: function(result) {
			  console.log(result);
			
	        jQuery("#ajax-loader").hide();
			jQuery('.uploadifive-button').addClass('success-upload'); 
          }
        });

})

	jQuery('#company-logo').prettyFile();
	jQuery('.demo').jPreview();

});


function recaptchaCallback() {
	if(typeof(grecaptcha)!='undefined')
	{
	var response = grecaptcha.getResponse();
	if(response!='')
	{
	   jQuery('#hidden-grecaptcha').val('1');
	   jQuery('#hidden-grecaptcha-error').hide();
	}else
	{
	   jQuery('#hidden-grecaptcha').val();
	}
	}
}