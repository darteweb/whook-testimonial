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
//class dbtask
class WhookTestimonial
{

public function get_testimonial($limit=1,$id="",$startlimit=0,$orderby="id",$ordertype="desc")
{
    global $wpdb;
	$table_name = $wpdb->prefix.'dweb_message';
    if($id=="")
	{
	  $sql = "SELECT * FROM ".$table_name." where msg_status = '0' order by ".$orderby." ".$ordertype." limit ".$startlimit.",".$limit;
	}else {
	  $sql = "SELECT * FROM ".$table_name." where id='".$id."' order by ".$orderby." ".$ordertype." limit ".$startlimit.",".$limit;
	}
	return $wpdb->get_results($sql);
}
	
public function get_question($id="")
{
    global $wpdb;
	$table_name = $wpdb->prefix.'dweb_question';
	if($id=="")
	{
	  $sql = "SELECT * FROM ".$table_name." where question_status  = '0'";
	}else
	{
	  $sql = "SELECT * FROM ".$table_name." where id  = '".$id."'";
	}
    return $wpdb->get_results($sql);
}	

public function get_setting()
{
    global $wpdb;
	$table_name = $wpdb->prefix.'dweb_setting';
	$sql = "SELECT * FROM ".$table_name." order by id desc";
	return $wpdb->get_results($sql);
}

public function calculate_rating($Answer,$total_option)
{
   $count = count($Answer);
   $total_rating = 0;
   foreach($Answer as $val)
   {
	  $total_rating = $total_rating+$val;
   }
   $total_rating = $total_rating/$count;
  // if($total_option>5)
   {
	 $part = $total_option/5;
	 $total_rating = $total_rating/$part;
   }
   $total_rating = round($total_rating); 
   if($total_rating<1) { $total_rating = 1; }
   return $total_rating;
}

public function filterData($val)
{
  $val = sanitize_text_field($val);
  $val = esc_html($val);
  return $val;
}

public function getRatingStar($msg_rating) {
          $html = '<ul class="rating pull-left float-left">';
          for($i=1;$i<=5;$i++) {
          $html.= '<li>';
              if($i<=$msg_rating) { 
              $html.= '<img src="'.whook_test_plugin_url.'images/star1.png">';
              } else { 
              $html.= '<img src="'.whook_test_plugin_url.'images/star2.png">';
              }
          $html.= '</li>';
            } 
         $html.= '</ul>';
return $html;
}
	
public function whook_test_submit_form()
{

if(isset($_POST) && !empty($_POST))
{

$setting = $this->get_setting();
if($setting[0]->setting_recaptcha_enable==1)
{
	$post_data = http_build_query(
		array(
			'secret' => $setting[0]->setting_recaptch_script,
			'response' => $_POST['g-recaptcha-response'],
			'remoteip' => $_SERVER['REMOTE_ADDR']
		)
	);
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $post_data
		)
	);
	$context  = stream_context_create($opts);
	$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
	$result = json_decode($response);
	if(!$result->success) {
		die('InvalidCaptch');
	}
}


if($_POST['msg_valid']=="")
{	
global $wpdb;
session_start();
date_default_timezone_set("Asia/Kolkata");

$question = $this->get_question();
$msg_question = '';

if(isset($question) && !empty($question))
{
   $QuesArray = array();
   foreach($question as $val)
   {
	   $QuesArray[$val->id]['id'] = $val->id;
	   $QuesArray[$val->id]['question'] = $val->question;
   }
   $msg_question = serialize($QuesArray);
}

$msg_name = '';
$msg_email = '';
$msg_mobile = '';
$msg_city = '';
$msg_state = '';
$msg_visite_date = '';
$msg_message = '';
$msg_state = '';
$msg_question_ans = '';
$msg_rating = '';
$msg_show_rating = '0';
$msg_question_option = '';


if(isset($_POST['msg_name']))
{
  $msg_name = $this->filterData($_POST['msg_name']);
}
if(isset($_POST['msg_email']))
{
  $msg_email = $this->filterData($_POST['msg_email']);
}
if(isset($_POST['msg_mobile']))
{
  $msg_mobile = $this->filterData($_POST['msg_mobile']);
}
if(isset($_POST['msg_city']))
{
  $msg_city = $this->filterData($_POST['msg_city']);
}
if(isset($_POST['msg_state']))
{
  $msg_state = $this->filterData($_POST['msg_state']);
}
if(isset($_POST['msg_visite_date']))
{
  $msg_visite_date = $this->filterData($_POST['msg_visite_date']);
}
if(isset($_POST['msg_message']))
{
  $msg_message = $this->filterData($_POST['msg_message']);
}
if(isset($_POST['option']))
{
  $option = array();
  foreach($_POST['option'] as $key=>$val)
  {
     $option[$key] = $this->filterData($val);
  }
  
  $hid_total_option = $this->filterData($_POST['hid_total_option']);
  $msg_rating = $this->calculate_rating($option,$hid_total_option);
  
  if($setting[0]->setting_rating_show==1)
  {
     $msg_show_rating = '1';   
  }
  
  if(isset($setting[0]->setting_rating_type) && $setting[0]->setting_rating_type==1)
  {
     $setting_rating_number = explode(",",$setting[0]->setting_rating_number);
	 $rating_number = array();
	 foreach($setting_rating_number as $val)
	 {
       $rating_number[$val] = $val;
	 }
	 $msg_question_option = serialize($rating_number);
  }elseif(isset($setting[0]->setting_rating_type) && $setting[0]->setting_rating_type==2)
  {
     $msg_question_option = $setting[0]->setting_rating_words;
  }else
  {
     $msg_question_option = serialize(whook_test_default_range);
  }
  $msg_question_ans = serialize($option);
}

		$today = $date = date('Y-m-d H:i:s');
		$data = array('msg_name'=>$msg_name,
					  'msg_email'=>$msg_email,
					  'msg_mobile'=>$msg_mobile,
					  'msg_city'=>$msg_city,
					  'msg_state'=>$msg_state,
					  'msg_visite_date'=>$msg_visite_date,
					  'msg_message'=>$msg_message,
					  'msg_question_ans'=> $msg_question_ans,
					  'msg_question'=>$msg_question,
					  'msg_question_option'=>$msg_question_option,
					  'msg_rating'=>$msg_rating,
					  'msg_show_rating'=>$msg_show_rating,
					  'msg_status'=>'1',
					  'msg_ip_address'=>$_SERVER['REMOTE_ADDR'],
					  'msg_browser'=>$_SERVER['HTTP_USER_AGENT'],
					  'msg_submit_date'=>$today
					 );
					
				if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
				{
					include(whook_test_path.'whook-class/upload-class.php');
					$uploadfive = new whook_test_uploadfive();
					$files = array();
	                $files['file']['name'] = $_FILES['file']['name'];	
	                $files['file']['tmp_name'] = $_FILES['file']['tmp_name'];	
					$uploadfive->upload_file($files);	
				}
				
				if(isset($_SESSION["profile_photo"]) && !empty($_SESSION["profile_photo"]))
				{
				     $data['msg_profile_image'] = $_SESSION["profile_photo"];
					 unset($_SESSION["profile_photo"]);
				}
				
			    $dweb_message = $wpdb->prefix.'dweb_message';
                $return = $wpdb->insert($dweb_message,$data);
				
			   if($return=="1" && $setting[0]->setting_mail_enable==1)
			   {
				   $whook_test_site_url = whook_test_site_url;
				   $logo_img ='/wp-content/uploads/2017/06/logo_new.png';
				   $msg_body = "<div style='width:100%; display:block;'><img src='".$whook_test_site_url.$logo_img."' title='".$data['msg_name']."' style ='max-width: 100%; display: block; margin:auto;'></div>";
				   $msg_body.= '<table style = "width: 400px; max-width: 100%; margin-top: 50px !important; margin:auto; border: 1px solid #ddd; border-spacing: 0; border-collapse: collapse; margin-bottom: 150px;">';
				   
				   if(isset($data['msg_profile_image']) && !empty($data['msg_profile_image']))
				   {
				      $base_url = "/wp-content/plugins/dweb-message/whook_test_upload_profile/".$data['msg_profile_image'];
					  $path = $_SERVER['DOCUMENT_ROOT'].$base_url;

					  if(file_exists($path))
					  {
					       $img = "<img src='".$whook_test_site_url.$base_url."' title='".$data['msg_name']."' style ='height: 150px; max-width: 100%; display: block;' >";
						   $msg_body.= '<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">Profile : </td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$img.' </td>
									    </tr>';
					  }  
				   }
					       $msg_body.= '<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">Name : </td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$data['msg_name'].' </td>
									</tr>
									<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">Email : </td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$data['msg_email'].' </td>
									</tr>									
									<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">Mobile : </td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$data['msg_mobile'].' </td>
									</tr>	
									
									<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">State : </td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$data['msg_state'].' </td>
									</tr>
									
									<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">Date of Visit :</td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$data['msg_visite_date'].' </td>
										 
									</tr>
									
									
									<tr>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">Message : </td>
                                         <td style = "padding: 8px; line-height: 1.42857143; vertical-align: top;  border: 1px solid #eaeaea;">'.$data['msg_message'].' </td>
									</tr>
									
							    </table>';
				   $to = $setting[0]->setting_to;
				   $subject = $setting[0]->setting_subject." - ".$data['msg_name'];
				   $message =  $msg_body;
				   
				   
				   $headers = 'Content-Type: text/html; charset=UTF-8
				               From: '.$setting[0]->setting_from;
				   wp_mail( $to, $subject, $message, $headers, $attachments="" );
				   die("success");

			   }elseif($return=="1")
			   {
				  die("success");
			   }
			   else
			   {
			       die("error");
			   }												
	 }else
     {
     die("error");
     }
  }else
  {
     die("error");
  }


}

public function whook_delete_image()
{
if(isset($_POST['img']) && !empty($_POST['img']))
{
		  $img = $this->filterData($_POST['img']);
		  $msg_id = $this->filterData($_POST['msg_id']);
		  $Path = whook_test_path.'whook_test_upload_profile/'.$img;
		  if(!unlink($Path))
		  {
			 die("error");
		  }
		  else
		  {
			 global $wpdb;
			 $dweb_message = $wpdb->prefix.'dweb_message';
			 $return = $wpdb->query("UPDATE ".$dweb_message." SET msg_profile_image='' WHERE id='".$msg_id."'");
		  }
		 if($return!="")
		 {
		   die('<div class=" alert alert-success">Successfully delete image</div>');
		 } 
	}
	else
	{
   		die("error");
	}
}

public function delete_data($table)
{
   global $wpdb;
   $ids = $this->filterData($_POST['id']);
   $ids = implode(',',$ids);
   $wpdb->query( "DELETE FROM ".$table." WHERE id IN($ids)" );
   die("success");
}

public function whook_test_update_testimonial()
{
	if(isset($_POST['msg_id']) && !empty($_POST['msg_id']))
	{
		 global $wpdb;
		 $dweb_message = $wpdb->prefix.'dweb_message';
		 
		 $msg_name = $this->filterData($_POST['msg_name']);
		 $msg_email = $this->filterData($_POST['msg_email']);
		 $msg_mobile = $this->filterData($_POST['msg_mobile']);
		 $msg_state = $this->filterData($_POST['msg_state']);
		 $msg_city = $this->filterData($_POST['msg_city']);
		 $msg_message = $this->filterData($_POST['msg_message']);
		 $msg_status = $this->filterData($_POST['msg_status']);
		 $msg_visite_date = $this->filterData($_POST['msg_visite_date']);
		 $msg_id = $this->filterData($_POST['msg_id']);
		 
		 $return = $wpdb->query("UPDATE ".$dweb_message." SET msg_name='".$msg_name."', msg_email='".$msg_email."', msg_mobile='".$msg_mobile."',msg_state='".$msg_state."',msg_city='".$msg_city."', msg_message='".$msg_message."', msg_status='".$msg_status."', msg_visite_date='".$msg_visite_date."' WHERE id='".$msg_id."'");
		 if($return!="")
		 {
			die("success");
		 } 
	}else
	{
	   die("error");
	}
}

public function update_question()
{
	if(isset($_POST['ques_id']) && !empty($_POST['ques_id']))
	{
		global $wpdb;
		$dweb_question = $wpdb->prefix.'dweb_question';
		
		$question = $this->filterData($_POST['question']);
		$question_status = $this->filterData($_POST['question_status']);
		$ques_id = $this->filterData($_POST['ques_id']);
		
		$return = $wpdb->query("UPDATE ".$dweb_question." SET question='".$question."',question_status='".$question_status."'  WHERE id='".$ques_id."'");
		if($return!="")
		{
		die("success");
		} 
	}
	else
	{
	   die("error");
	}
}

public function add_new_question()
{
	if(isset($_POST['question']) && !empty($_POST['question']))
	{
		$question = $this->filterData($_POST['question']);
		$question_status = $this->filterData($_POST['question_status']);

		$data = array('question'=>$question,
					  'question_status'=>$question_status
					  );
		global $wpdb;
		$dweb_question = $wpdb->prefix.'dweb_question';
		$return = $wpdb->insert($dweb_question,$data);
		if($return!="")
		{
			die("success");
		
		}else
		{
		   die("error");
		}
	}else
	{
	   die("error");
	}
}


public function update_settings()
{
	if(isset($_POST['setting_to']) && !empty($_POST['setting_to']))
	{
		$setting_input_field = '';
		$setting_recaptcha_enable = '';
		$setting_rating_type = '';
		$setting_recaptcha_key = '';
		$setting_feedback_layout = '';
		$setting_mail_enable = '';
		$setting_rating_words = '';
		if(isset($_POST['form_field']))
		{
		    $form_field = array();
			foreach($_POST['form_field'] as $key=>$val)
			{
				if(isset($val['show'])) {  $form_field[$key]['show'] = $this->filterData($val['show']); }
				if(isset($val['required'])) {  $form_field[$key]['required'] = $this->filterData($val['required']); }
			    
			}
			$setting_input_field = serialize($form_field);
		}
		if(isset($_POST['setting_recaptcha_enable']))
		{
		    $setting_recaptcha_enable = $this->filterData($_POST['setting_recaptcha_enable']);
		}
		if(isset($_POST['setting_rating_type']))
		{
		    $setting_rating_type = $this->filterData($_POST['setting_rating_type']);
		}	
		if(isset($_POST['setting_feedback_layout']))
		{
		    $setting_feedback_layout = $this->filterData($_POST['setting_feedback_layout']);
		}
		if(isset($_POST['setting_mail_enable']))
		{
		    $setting_mail_enable = $this->filterData($_POST['setting_mail_enable']);
		}			
		if(isset($_POST['setting_rating_words']))
		{
		    $rating_words = array();
			foreach($_POST['setting_rating_words'] as $key=>$val)
			{
			  $rating_word[$key] = $this->filterData($val);
			}
			$setting_rating_words = serialize($rating_word);
		}
					
		global $wpdb;
		$dweb_setting = $wpdb->prefix.'dweb_setting';
		$sql = "UPDATE ".$dweb_setting." SET setting_to='".$this->filterData($_POST['setting_to'])."',
		                                     setting_from='".$this->filterData($_POST['setting_from'])."',
											 setting_subject='".$this->filterData($_POST['setting_subject'])."',
											 setting_mail_enable='".$setting_mail_enable."',
											 setting_input_field='".$setting_input_field."',
											 setting_rating_type ='".$setting_rating_type."',
											 setting_rating_number='".$this->filterData($_POST['setting_rating_number'])."',
											 setting_rating_words='".$setting_rating_words."',
											 setting_form_layout='".$this->filterData($_POST['setting_form_layout'])."',
											 setting_recaptcha_enable='".$setting_recaptcha_enable."',
											 setting_recaptcha_key='".$this->filterData($_POST['setting_recaptcha_key'])."',
											 setting_recaptch_script='".$this->filterData($_POST['setting_recaptch_script'])."',
											 setting_feedback_layout='".$setting_feedback_layout."',
											 setting_rating_show='".$this->filterData($_POST['setting_rating_show'])."',
											 setting_feedback_limit='".$this->filterData($_POST['setting_feedback_limit'])."',
											 setting_feedback_showtype='".$this->filterData($_POST['setting_feedback_showtype'])."',
											 setting_feedback_showby='".$this->filterData($_POST['setting_feedback_showby'])."'
											 WHERE id ='1'";
		$return = $wpdb->query($sql);
		die("success");
	}
	else
	{
	   die("error");
	}
}


}
