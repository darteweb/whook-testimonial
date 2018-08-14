<?php
/*This file is part of Whook Testimonial.

    Whook Testimonial is free plugin: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Whook Testimonial is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Whook Testimonial.  If not, see <https://www.gnu.org/licenses/>.*/
    
class whook_test_form
{
var $dtobj;

public function show_whook_test_whook_test_question_updatefrm()
{
	if(isset($_POST['id']))
	{
		$question = $this->dtobj->get_question($_POST['id']);
		$title = "Edit Question";
		$btn = "question-update-btn";
	}else
	{
		$title = "Add New Question";
		$btn = "question-add-btn";
	}	
	?>
       <div class="modal-header">
        <h4 class="modal-title" id="exampleModalPopoversLabel"><?php echo $title;?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="" method="post" id="question-frm" novalidate="novalidate">
      <div class="modal-body">
      <div class="col-md-12 nopadding" >
    		<input type="hidden" class="form-control" name="ques_id" id="ques_id" value="<?php if(isset($question[0]->id)) { echo $question[0]->id; } ?>">
     
		  <div class="form-group">
			<label for="question">Question : </label>
			<input type="text" class="form-control" name="question" id="question" value="<?php if(isset($question[0]->question)) { echo $question[0]->question; } ?>">
		  </div>     
        
        <div class="form-group">
            <label for="question_status">Status : </label>
            <select name="question_status" class="form-control">
              <option value="0" <?php if(isset($question[0]->question_status) && $question[0]->question_status=='0') {echo 'selected';}?>>Active</option>
              <option value="1" <?php if(isset($question[0]->question_status) && $question[0]->question_status=='1') {echo 'selected';}?>>Inactive</option>
            </select>
        </div>
      </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="<?php echo $btn;?>"><span class="oi oi-check"></span> Save</button>
      </div>
      </form>
    <?php
	die();	
}

public function whook_test_settings_showfrm()
{
$result = $this->dtobj->get_setting(); 
$rate = array(4=>"Excellent",3=>"Good",2=>"Satisfactory",1=>"Poor")
?>
<div class="clearfix"></div>
<form action="" method="post" class="valid-frm">
<div class="col-md-6">
<h2>Form Settings</h2>
<?php
$input_field = array('name'=>'Name','email'=>'Email','mobile'=>'Mobile','city'=>'City','state'=>'State','date'=>'Date','message'=>'Message','profile_photo'=>'Profile Photo');
$setting_input_field = array();
$setting_rating_words = array();
if(!empty($result[0]->setting_input_field))
{
  $setting_input_field = unserialize($result[0]->setting_input_field);
}
if(!empty($result[0]->setting_rating_words))
{
  $setting_rating_words = unserialize($result[0]->setting_rating_words);
}
?>
<table class="table">
<thead>
<tr>
<th>Input Field Name</th>
<th>Show</th>
<th>Required</th>
</tr>
</thead>
<tbody>
<?php foreach($input_field as $key=>$val) { ?>
<tr>
<th><?php echo $val;?></th>
<td><input type="checkbox" name="form_field[<?php echo $key;?>][show]" <?php if(isset($setting_input_field[$key]['show']) && $setting_input_field[$key]['show']=='1') { echo 'checked';} ?> value="1"></td>
<td><input type="checkbox" name="form_field[<?php echo $key;?>][required]" <?php if(isset($setting_input_field[$key]['required']) && $setting_input_field[$key]['required']=='1') { echo 'checked';} ?> value="1"></td>
</tr>
<tr>
<?php } ?>
<tbody>
</table>
<div class="col-md-12 nopadding"><hr/></div>
<h4>Question Rating</h4>
<div class="col-md-5 nopadding form-group"> 
    <div class="col-md-3 nopadding"><label for="rating_value_1"> Rate 0-10</label></div><div class="col-md-8"><input type="radio" class="form-control" name="setting_rating_type" id="rating_type_1" <?php if(isset( $result[0]->setting_rating_type) &&  $result[0]->setting_rating_type=='1') { echo 'checked';} ?> value="1"></div>
    <div class="col-md-12 nopadding">
    <input type="text" class="form-control" name="setting_rating_number" id="rating_value_1" value="<?php echo $result[0]->setting_rating_number; ?>">
    <?php $rating_value_1 = sanitize_text_field( $_POST['rating_value_1'] );
    update_post_meta( $post->ID, 'rating_value_1', $rating_value_1 );?>
    <p style="margin: 10px 0px 0px;"><b>Ex- 1,2,3,4,5</b></p>
    </div>
</div>

<div class="col-md-7 norpadding "> 
    <div class="col-md-6 nopadding"><label for="rating_value_2"> Rate Excellent To Poor</label></div><div class="col-md-6"><input type="radio" class="form-control" name="setting_rating_type" id="rating_type_2" <?php if(isset( $result[0]->setting_rating_type) &&  $result[0]->setting_rating_type=='2') { echo 'checked';} ?> value="2"></div>
    <div class="clearfix"></div>
    <p></p>
    <?php foreach($rate as $key=>$val) { ?>
    <?php 
	      $checked = '';
	      if(isset($setting_rating_words[$key]) && $setting_rating_words[$key]==$val) { 
	      $checked = 'checked';
		  }
    ?>
    <input type="checkbox" <?php echo $checked;?> class="form-control" name="setting_rating_words[<?php echo $key;?>]" id="rating_check_<?php echo $key;?>" value="<?php echo $val;?>" >
    <label style="margin: 0px 8px 0px 5px;" for="rating_check_<?php echo $key;?>"> <?php echo $val;?></label>
	<?php } ?>
</div>
<div class="clearfix"></div>
<div class="col-md-12 nopadding"><hr/></div>
<h4>Form Layout</h4>

<div class="col-md-12 nopadding"> 
    <div class="col-md-6 nopadding"><label for="form_layout"> Layout</label>
    <?php $layout = array(1=>'1 Column',2=>'2 Column'); ?>
    <select class="form-control" required name="setting_form_layout" id="form_layout" >
    <option value="">-Choose-</option>
    <?php foreach($layout as $key=>$val) { 
	$selected = ''; ?>
    <?php if(isset( $result[0]->setting_form_layout) &&  $result[0]->setting_form_layout==$key) { echo $selected = 'selected';} ?>
    <option value="<?php echo $key; ?>" <?php echo $selected?> ><?php echo $val;?></option>
    <?php } ?>
    </select>
    </div>
</div>
<div class="col-md-12 nopadding"><hr/></div>
<h4>Google Recaptch</h4>

<div class="col-md-12 nopadding form-group"> 
    <div class="col-md-3 nopadding"><label for="form_recaptch"> Recaptch</label></div>
    <div class="col-md-9">
    <input type="checkbox" name="setting_recaptcha_enable" class="form-control" id="form_recaptch"  <?php if(isset( $result[0]->setting_recaptcha_enable) &&  $result[0]->setting_recaptcha_enable=='1') { echo 'checked';} ?>  value="1">
    </div>
</div>

<div class="col-md-12 nopadding recaptch-field form-group"> 
    <div class="col-md-12 nopadding form-group"><label for="form_recaptch_key">Site Key</label>
    <input type="text" name="setting_recaptcha_key" class="form-control" id="form_recaptch_key" value="<?php echo $result[0]->setting_recaptcha_key; ?>">
    </div>
    <div class="col-md-12 nopadding"><label for="form_recaptch_script">Script Key</label>
    <input type="text" name="setting_recaptch_script" class="form-control" id="form_recaptch_script" value="<?php echo $result[0]->setting_recaptch_script; ?>">
    </div>
</div>

</div>

<div class="col-md-6">
<h2>Feedback Show Settings</h2>

<h4>Feedback Layout</h4>

<div class="col-md-12 nopadding form-group"> 
    <div class="col-md-1 nopadding"><input type="radio" name="setting_feedback_layout" class="form-control" id="feedback_layout" <?php if(isset( $result[0]->setting_feedback_layout) &&  $result[0]->setting_feedback_layout=='1') { echo 'checked';} ?>  value="1"></div>
    <div class="col-md-2"><img src="<?php echo whook_test_plugin_url.'images/demo-img.jpg'?>" class="img-responsive" /></div>
    <div class="col-md-7"><b>Name</b><br/><b>City</b><br/><b>Message</b><br/><b>Rating</b>
    </div>
    <div class="col-md-12" style="padding: 15px 0px 0px;"><b>Shortcode</b> - [whook-test-feedback-show layout=1 limit=10]</div>
    <div class="clearfix form-group"></div>
     
    <div class="col-md-1 nopadding"><input type="radio" name="setting_feedback_layout" class="form-control" id="feedback_layout" <?php if(isset( $result[0]->setting_feedback_layout) &&  $result[0]->setting_feedback_layout=='2') { echo 'checked';} ?>  value="2"></div>
    <div class="col-md-7"><b>Name</b><br/><b>City</b><br/><b>Message</b><br/><b>Rating</b>
    </div>
    <div class="col-md-12" style="padding: 15px 0px 0px;"><b>Shortcode</b> - [whook-test-feedback-show layout=2 limit=10]</div>
</div>

<div class="col-md-12 nopadding form-group"> 
    <div class="col-md-3 nopadding"><label for="mail_enable"> Show Rating</label></div>
    <div class="col-md-9">
    <input type="checkbox" name="setting_rating_show" class="form-control" id="setting_rating_show" <?php if(isset( $result[0]->setting_rating_show) &&  $result[0]->setting_rating_show=='1') { echo 'checked';} ?>  value="1">
    </div>
</div>

<div class="col-md-12 nopadding form-group"> 
    <div class="col-md-3 nopadding"><label for="mail_enable"> Feedback Limit</label></div>
    <div class="col-md-9">
    <input type="number" name="setting_feedback_limit" class="formcontrol" min="1" id="feedback_limit" value="<?php echo $result[0]->setting_feedback_limit; ?>" style="width: 80px;">
    </div>
</div>

<div class="col-md-12 nopadding form-group"> 
    <div class="col-md-3 nopadding"><label for="show_type"> Show Type</label></div>
    <div class="col-md-4">
    
    <?php $layout = array(1=>'ASC',2=>'DESC'); ?>
    <select class="form-control" required name="setting_feedback_showtype" id="show_type" >
    <option value="">-Choose-</option>
    <?php foreach($layout as $key=>$val) { ?>
	<?php $selected = ''; ?>
    <?php if(isset( $result[0]->setting_feedback_showtype) &&  $result[0]->setting_feedback_showtype==$key) { echo $selected = 'selected';} ?>
    <option value="<?php echo $key; ?>" <?php echo $selected; ?> ><?php echo $val;?></option>
    <?php } ?>
    </select>    
    
    </div>
</div>

<div class="col-md-12 nopadding form-group"> 
    <div class="col-md-3 nopadding"><label for="show_by"> Show By</label></div>
    <div class="col-md-4">
    
    <?php $layout = array(1=>'Date',2=>'Rating'); ?>
    <select class="form-control" required name="setting_feedback_showby" id="show_by" >
    <option value="">-Choose-</option>
    <?php foreach($layout as $key=>$val) { ?>
	<?php $selected = ''; ?>
    <?php if(isset( $result[0]->setting_feedback_showby) &&  $result[0]->setting_feedback_showby==$key) { echo $selected = 'selected';} ?>
    <option value="<?php echo $key; ?>" <?php echo $selected; ?> ><?php echo $val;?></option>
    <?php } ?>
    </select>    
    
    </div>
</div>

<div class="col-md-12 nopadding form-group"><hr/></div>

<h2>Mail Settings</h2>
<div class="col-md-12 nopadding form-group"> 
      <div class="col-md-12 nopadding form-group"> 
            <div class="col-md-3 nopadding"><label for="mail_enable"> Mail Enable</label></div>
            <div class="col-md-9">
            <input type="checkbox" name="setting_mail_enable" class="form-control" id="mail_enable" <?php if(isset( $result[0]->setting_mail_enable) &&  $result[0]->setting_mail_enable=='1') { echo 'checked';} ?>  value="1">
            </div>
      </div>
      <div class="col-md-8 nopadding"> 
      <div class="form-group">
        <label for="msg_name">Subject : </label>
        <input type="text" class="form-control" required="required" name="setting_subject" id="setting_subject" value="<?php if(isset($result[0]->setting_subject)) { echo $result[0]->setting_subject; } ?>">
      </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-8 nopadding"> 
      <div class="form-group">
        <label for="msg_name">To : </label>
        <input type="email" class="form-control email" required name="setting_to" id="setting_to" value="<?php if(isset($result[0]->setting_to)) { echo $result[0]->setting_to; } ?>">
      </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-8 nopadding"> 
      <div class="form-group">
        <label for="msg_name">From : </label>
        <input type="text" class="form-control" required name="setting_from" id="setting_from" value="<?php if($result[0]->setting_from) { echo $result[0]->setting_from; } ?>">
      </div>
      </div>
       <div class="clearfix"></div>
      <div class="col-md-8 nopadding"> 
      <div class="form-group">
              <button type="submit" class="btn btn-primary" id="btn-setting"><span class="oi oi-check"></span> Save</button>
      </div>
      </div> 
</div>
</div>
      </form>

<div class="col-md-12 nopadding">
<h2>Form Shortcode </h2>
[whook-test-form]
</div>
<div class="preload_area" style="display:none;"><img src="<?php echo whook_test_plugin_url;?>/default.svg"></div>
<?php
}

public function whook_test_update_frm()
{
	if(isset($_POST['id']))
	{
	$result =  $this->dtobj->get_testimonial($limit=1,$_POST['id']);
	$question = $this->dtobj->get_question();
	
	if(isset($result) && !empty($result[0]->msg_question)) {
	      $setquestion= unserialize($result[0]->msg_question);
	}

	if(isset($result) && !empty($result)) {
	$question_ans = unserialize($result[0]->msg_question_ans);
	$question_option = unserialize($result[0]->msg_question_option);
	
	?>
	<div class="clearfix"></div>
    <br/>
     <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Personal Details</a></li>
        <?php if(!empty($question_ans)) { ?>
        <li role="presentation"><a href="#answer" aria-controls="answer" role="tab" data-toggle="tab">Answer</a></li>
        <?php } ?>
     </ul>

    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="details">
		  <input type="hidden" class="form-control" name="msg_id" id="msg_id" value="<?php echo $result[0]->id;?>">
		  <div class="" style="margin-top:10px;" id="whook_delete_image">
		  <div class="form-group">
		  <?php if(isset($result[0]->msg_profile_image) && $result[0]->msg_profile_image!="")  {
			  
			    $uploads = wp_upload_dir();
		        $path = $uploads['basedir'].'/uploads-profile/'.$result[0]->msg_profile_image;
				if(file_exists($path))
				{
					$img_url = $uploads['baseurl'].'/uploads-profile/'.$result[0]->msg_profile_image;
					//<button type="button" class="btn btn-sm btn-danger" data-img="'.$result[0]->msg_profile_image.'" id="delete-img"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

					echo '<div class="clearfix"></div>
						  <div class="col-md-12">
						  <img style="height:150px;border: 1px solid #ccc;" data-img="'.$result[0]->msg_profile_image.'" src="'.$img_url.'" class="img-responsive pull-right">
						  </div>
						  <div class="clearfix"></div>';
				}
		   
		    } ?>
		  </div>
          </div>
          <div class="col-md-6"> 
		  <div class="form-group">
			<label for="msg_name">Name : </label>
			<input type="text" class="form-control" name="msg_name" id="msg_name" value="<?php echo $result[0]->msg_name;?>">
		  </div>
          </div>
          <div class="col-md-6"> 
		  <div class="form-group">
			<label for="msg_email">Email : </label>
			<input type="text" class="form-control" name="msg_email" id="msg_email" value="<?php echo $result[0]->msg_email;?>">
		  </div>
          </div>
          <div class="col-md-6"> 
		  <div class="form-group">
			<label for="msg_mobile">Mobile No : </label>
			<input type="text" class="form-control" name="msg_mobile" id="msg_mobile" value="<?php echo $result[0]->msg_mobile;?>">
		  </div>
          </div>
          
          <div class="col-md-6"> 		  
		  <div class="form-group">
			<label for="msg_state">State : </label>
			<input type="text" class="form-control" name="msg_state" id="msgmsg_state_city" value="<?php echo $result[0]->msg_state;?>">
		  </div>
          </div>
          
          <div class="col-md-6"> 		  
		  <div class="form-group">
			<label for="msg_city">City : </label>
			<input type="text" class="form-control" name="msg_city" id="msg_city" value="<?php echo $result[0]->msg_city;?>">
		  </div>
          </div>
          <div class="col-md-6"> 		  
		  <div class="form-group">
			<label for="msg_status">Visit Date : </label>
            <input type="date" class="form-control" name="msg_visite_date" value="<?php echo $result[0]->msg_visite_date?>" required="" aria-required="true">
		  </div>      
          </div>
          <div class="col-md-12"></div>
                    <div class="col-md-6"> 		  
		  <div class="form-group">
			<label for="msg_status">Status : </label>
			<select id="msg_status" name="msg_status" class="form-control">
			  <option value="0" <?php if($result[0]->msg_status=='0') {echo 'selected';}?> >Active</option>
			  <option value="1" <?php if($result[0]->msg_status=='1') {echo 'selected';}?> >Inactive</option>
			</select>
		  </div>      
          </div>
          <div class="col-md-6"> 
		  <div class="form-check">
			<label for="msg_message">Message : </label>
			<textarea class="form-control" name="msg_message" id="msg_message"><?php echo $result[0]->msg_message;?></textarea>
            <br/>
		  </div>
          </div>
          <br/>
           </div><!--details--> 
           <div role="tabpanel" class="tab-pane" id="answer"> 
           <br/>  
		   <?php 
		   $i=1;
		   foreach($setquestion as $key=>$val)
				{ ?>
				<div class="col-md-6 quetion-size">
				<?php	echo $i++;
					echo")";
					echo" ";
					echo $val['question'];
					echo "<br/>Ans. ".$question_option[$question_ans[$val['id']]];
					?> <br/>
		   </div> 
		  <?php }?>
          <br/>

		  <div class="col-md-12 rating-area" ><span class="pull-left">Rating :</span> 
          <?php echo $this->dtobj->getRatingStar($result[0]->msg_rating); ?>
          </div>          
          
          </div><!--answer-->
          </div>


          
		  <div class="col-md-12 nopadding" id="msg"></div>
	<?php }else {
		  die("error");	
	}
	}
	die();
}

public function getFeedbackHTML($startlimit,$limit,$layout)
{

 	$setting = $this->dtobj->get_setting();

	if($limit=='' && $setting[0]->setting_feedback_limit!='')
	{
	   $limit = $setting[0]->setting_feedback_limit;
	}else
	{
	   $limit = 10;
	}
	
	$orderby = 'id';
	$ordertype = 'desc';
	
	if(!empty($setting[0]->setting_feedback_showtype))
	{
	   $ordertype_array = array(1=>'ASC',2=>'DESC');
	   $ordertype = $ordertype_array[$setting[0]->setting_feedback_showtype];
	}
	if(!empty($setting[0]->setting_feedback_showby))
	{
	   $feedback_showby = array(1=>'msg_submit_date',2=>'msg_rating');
	   $orderby = $feedback_showby[$setting[0]->setting_feedback_showby];
	}	
	$result = $this->dtobj->get_testimonial($limit,$id="",$startlimit,$orderby,$ordertype);
	?>
    <?php
    
    foreach($result as $val)
	{
	 if(isset($val->msg_profile_image) && !empty($val->msg_profile_image))
	  {
	      	$uploads = wp_upload_dir();
			$path = $uploads['basedir']."/uploads-profile/".$val->msg_profile_image;
			$base_url = $uploads['baseurl']."/uploads-profile/".$val->msg_profile_image;
			if(file_exists($path))
			{
				$img_url = $base_url;
			}else
			{
				$img_url = whook_test_plugin_url.'images/demo.jpg';
			}
	  }else
	  {
		  $img_url = whook_test_plugin_url.'images/demo.jpg';
	  }
	  
      $msg_class = 'width-80';
	  $hidden = '';
	  if(($setting[0]->setting_feedback_layout==2) || ($layout=='2'))
	  {
         $msg_class = 'width-100';
	     $hidden = 'style="display:none;"';
	  }
	    ?>
        <div class="width-100 bottom-border-test">
            <div <?php echo $hidden;?> class=" img-area">
            <img src="<?php echo esc_url($img_url);?>" class="img-profile">
            </div>
            <div class="<?php echo $msg_class;?> nopadding msg-content">
                <h4 class="profile-title"><b><?php echo esc_html($val->msg_name);?></b></h4>
                <h5 class="profile-title"><i><?php echo esc_html($val->msg_city);?></i></h5>
                <p><?php echo esc_html($val->msg_message);?></p>
           
          <?php 
		  if($setting[0]->setting_rating_show=='1' && $val->msg_show_rating == '1') { ?>
          <div class="float-left rating-area" ><span class="float-left">Rating :</span> 
          <?php echo $this->dtobj->getRatingStar($val->msg_rating); ?>
          </div>
          <?php } ?>
            </div>
        </div>
        <div class="clearfix"></div>
		<?php
	}
	?>
    <input type="hidden" name="hid_start_limit" id="hid_start_limit" value="<?php echo $startlimit;?>" >
    <input type="hidden" name="hid_end_limit" id="hid_end_limit" value="<?php echo $limit;?>" >
    <?php
}

public function whook_test_show_testimonial($limit,$layout)
{   
    $startlimit = 0;
	?>
    <div class="width-100 nopadding msg-status" id="msg_content">
    <?php
	$this->getFeedbackHTML($startlimit,$limit,$layout);
	?>  
</div>
    <br/>
    <div class="form_link pull-right">
    <!-- <a href=""  alt="" title="Feedback Form"><u>Feedback Form</u> </a>--></div>
    </div><!--msg_content-->
 <br/><br/>
    <?php
}	
public function whook_test_show_form($result = array())
{
    $layout_class = '';
    $column_class = '';
    $clear_fix = '';
	$required = '<sup class="red_color">*</sup>';
	$input_field = array();

	if(isset($result[0]->setting_input_field) && !empty($result[0]->setting_input_field))
	{
	  $input_field = unserialize($result[0]->setting_input_field);
	}

	$layout_class = 'layout-1';
	$column_class = 'dt-input-box-1';	
	
	if((isset($result[0]->setting_form_layout) && $result[0]->setting_form_layout==2))
	{
	   $layout_class = 'layout-2';
	   $column_class = 'dt-input-box-2';
	   $clear_fix = '';
	}
	?>
    <div class="clearfix"></div>
    <div class="msg-form-area float-left <?php echo $layout_class;?>">

    <div class=" center-block float-none">
        <form action = "" method="post" id="msg-frm" class="font_size_question" enctype="multipart/form-data" >
      <?php if(isset($input_field['name']['show'])) { ?>
      <div class="form-group <?php echo $column_class;?>">
        <label for="msg_name">Name <?php if(isset($input_field['name']['required'])) { echo $required; } ?></label>
        <input type="text" class="form-control" name="msg_name" id="msg_name" value="" <?php if(isset($input_field['name']['required'])) { ?>required<?php } ?> >
      </div>
      <?php } ?>
      <?php if(isset($input_field['email']['show'])) { ?>
      <div class="form-group <?php echo $column_class;?>">
        <label for="msg_email">Email <?php if(isset($input_field['email']['required'])) { echo $required; } ?></label>
        <input type="text" class="form-control email" name="msg_email" id="msg_email" value="" <?php if(isset($input_field['email']['required'])) { ?>required<?php } ?> >
      </div>
      <?php } ?>
      <?php echo $clear_fix;?>
      <?php if(isset($input_field['mobile']['show'])) { ?>
      <div class=" form-group <?php echo $column_class;?>">
        <label for="msg_mobile">Mobile No <?php if(isset($input_field['mobile']['required'])) { echo $required; } ?></label>
        <input type="text" class="form-control" name="msg_mobile" id="msg_mobile" value="" minlength="10" maxlength="10" <?php if(isset($input_field['email']['required'])) { ?>required<?php } ?> >
      </div>
      <?php } ?>
      <?php if(isset($input_field['city']['show'])) { ?>
       <div class="form-group <?php echo $column_class;?>">
        <label for="msg_city">City <?php if(isset($input_field['city']['required'])) { echo $required; } ?></label>
        <input type="text" class="form-control" name="msg_city" id="msg_city" value="" <?php if(isset($input_field['city']['required'])) { ?>required<?php } ?> >
       </div>
      <?php } ?>
      <?php echo $clear_fix;?>
      <?php if(isset($input_field['state']['show'])) { ?>
      <div class="form-group <?php echo $column_class;?>">
        <label for="msg_state">State <?php if(isset($input_field['state']['required'])) { echo $required; } ?></label>
        <input type="text" class="form-control" name="msg_state" id="msg_city" value="" <?php if(isset($input_field['state']['required'])) { ?>required<?php } ?> >
      </div>
      <?php } ?>

      <?php if(isset($input_field['date']['show'])) { ?>
      <div class="form-group <?php echo $column_class;?>">
        <label for="msg_visite_date">Date <?php if(isset($input_field['date']['required'])) { echo $required; } ?></label>
        <input type="date" class="form-control" name="msg_visite_date" value="" <?php if(isset($input_field['date']['required'])) { ?>required<?php } ?> >
      </div>
      <?php } ?>

      <?php echo $clear_fix;?>
      <div id="question-frm" class="width-100 float-left" style="margin-top:10px;">
    <?php
      $i=1;
      $question = $this->dtobj->get_question();
	   
	  if(isset($result[0]->setting_rating_type) && $result[0]->setting_rating_type=='1')
	  {
	      if(isset($result[0]->setting_rating_number) && !empty($result[0]->setting_rating_number))
		  {
		     $rating_number = $result[0]->setting_rating_number;
			 $rating_number = explode(",",$rating_number);
			 foreach ( $rating_number as $key => $val )
			 {
               $onearr[ $key+1 ] = $val;
			 }
			 $rating_options = $onearr;
		  }
	  }elseif(isset($result[0]->setting_rating_type) && $result[0]->setting_rating_type=='2')
	  {
	      if(isset($result[0]->setting_rating_words) && !empty($result[0]->setting_rating_words))
		  {
		     $rating_words = $result[0]->setting_rating_words;
			 $rating_options = unserialize($rating_words);
		  }	  
	  }else
	  {
	      $rating_options = whook_test_default_range;
	  }
	   
	     if(isset($question))
   		 {
			foreach($question as $Qkey=>$Qval) { ?>
            <div class="quetion-size float-left">
                <?php	echo $i++;
				echo")";
				echo" ";
				echo $Qval->question;
				?>
                    <br/>
                    <div class="form-check margin_radio_button">
                        <?php foreach($rating_options as $key=>$val) { ?>
                        <label for="option_<?php echo $key;?>_<?php echo $Qkey;?>"><input id="option_<?php echo $key;?>_<?php echo $Qkey;?>" type="radio" name="option[<?php echo $Qval->id;?>]" value="<?php echo $key;?>"> <?php echo $val;?></label>
                        <?php } ?>
                    </div>
                    <div class="width-100 clear_area"></div>
            </div>
            <div class="width-100 clear_area"></div>
            <?php }?>
            <input type="hidden" name="hid_total_option" value="<?php echo count($rating_options);?>">
                <?php }?>
</div>
<?php echo $clear_fix;?>

<?php if(isset($input_field['message']['show'])) { ?>
<div class="form-check <?php echo $column_class;?>">
    <label for="msg_message">Message <?php if(isset($input_field['message']['required'])) { echo $required; } ?></label>
    <textarea class="form-control" name="msg_message" id="msg_message" <?php if(isset($input_field['message']['required'])) { ?>required<?php } ?> ></textarea>
</div>
<?php }?>

<?php if(isset($input_field['profile_photo']['show'])) { ?>
<div class="form-check <?php echo $column_class;?>">
    <label for="file_upload">Profile Photo <?php if(isset($input_field['profile_photo']['required'])) { echo $required; } ?></label>
    <input <?php if(isset($input_field['profile_photo']['required'])) { ?>required<?php } ?> type="file" name="file" class="demo" multiple data-jpreview-container="#demo-1-container">
   <div id="demo-1-container" class="jpreview-container"></div>
</div>
<?php }?>


<?php echo $clear_fix;?>
<input type="text" class="form-control" name="msg_valid" style="display:none;" id="msg_valid" value="">
<div class="btn-msg-area width-100 float-left">
<?php if(isset($result[0]->setting_recaptcha_key) && !empty($result[0]->setting_recaptcha_key) && $result[0]->setting_recaptcha_enable==1) { ?>
    <div class="g-recaptcha" data-sitekey="<?php echo $result[0]->setting_recaptcha_key;?>" data-callback="recaptchaCallback" ></div>
<input id="hidden-grecaptcha" name="hidden-grecaptcha" type="hidden" />
<?php } ?>
<?php echo $clear_fix;?>
<button type="submit" class="btn btn-default" id="msg-submit-btn">Submit</button>
<div class="" style="display:none;" id="ajax-loader">
<img src="<?php echo whook_test_plugin_url;?>images/spinner.svg">
</div>
</div>

<div class="width-100" id="msg"></div>
</form>

</div>
</div>
<?php echo $clear_fix;?>
<?php
} 

} // end of class

?>
