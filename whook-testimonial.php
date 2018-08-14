<?php
/*
Plugin Name: Whook Testimonial 
Plugin URI: http://www.darteweb.com/
Version: 1.0
Author: D'arteweb
Description: This is testimonial plugin which is helpful for get visitor feedback.

 *  This program is free plugin: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>. */


define('whook_test_path',plugin_dir_path( __FILE__));
define('whook_test_site_url',site_url());
define('whook_test_plugin_url',plugin_dir_url(__FILE__));
define('whook_test_default_range', range(1,5));

// function to create the DB / Options / Defaults					
function whook_test_install() {
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    include(whook_test_path.'whook-class/install-class.php');
	$install = new whook_test_install();
	$install->create_table();
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'whook_test_install');

add_action('wp_head', 'whook_test_frontend_javascript' ); // Write our JS below here

function whook_test_frontend_javascript() { 
$timestamp = time();
?>
<script type="text/javascript" >
var whook_test_site_url = '<?php echo whook_test_site_url; ?>';
var whook_test_timestamp = '<?php echo $timestamp;?>';
var whook_test_unique_salt = '<?php echo md5('unique_salt'.$timestamp);?>';
</script>
<?php 
}

add_action('admin_menu', 'whook_test_admin_menu');
 
function whook_test_admin_menu(){
    add_menu_page('Whook Testimonials','Whook Testimonials','manage_options','whook-testimonial-table','whook_whook_test_table_show');
    add_submenu_page('whook-testimonial-table','Whook Testimonials','Questions','manage_options','whook-question-table','whook_test_question_table_show');
    add_submenu_page('whook-testimonial-table','Whook Testimonials','Global Settings','manage_options','whook-setting','whook_test_settings_show');
}

function whook_test_admin_script() {
   wp_enqueue_style('whook-test-bootstrap-min-script', whook_test_plugin_url."/bootstrap/css/bootstrap.min.css");
   wp_enqueue_style('whook-test-bootstrap-script', whook_test_plugin_url."css/dataTables.bootstrap.min.css");
   wp_enqueue_style('whook-test-jquery-datatables-style', whook_test_plugin_url."css/jquery.dataTables.min.css");
   wp_enqueue_style('whook-test-admin-css', whook_test_plugin_url."css/admin-css.css");
   wp_enqueue_style('whook-test-icon-script', whook_test_plugin_url."icons/css/open-iconic-bootstrap.css");
   wp_enqueue_style('whook-test-sweet-alert-style', whook_test_plugin_url."sweet-alert/css/sweetalert.css");

   wp_enqueue_script('whook-test-bootstrap-script', whook_test_plugin_url."/bootstrap/js/bootstrap.js");
   wp_enqueue_script('whook-test-dt-script', whook_test_plugin_url."js/jquery.dataTables.min.js");
   wp_enqueue_script('whook-test-bootstrap-dt-script', whook_test_plugin_url."js/dataTables.bootstrap.min.js");
   wp_enqueue_script('whook-test-sweetalert-script', whook_test_plugin_url."sweet-alert/js/sweetalert.min.js");
   wp_enqueue_script('whook-test-admin-script', whook_test_plugin_url."js/admin-js.js");
}

add_action('admin_enqueue_scripts', 'whook_test_admin_script');

function whook_test_frontend_scripts() {
    wp_enqueue_style('whook-test-sweet-alert-style', whook_test_plugin_url."sweet-alert/css/sweetalert.css");
    wp_enqueue_script('whook-test-sweetalert-script', whook_test_plugin_url."sweet-alert/js/sweetalert.min.js");

    wp_enqueue_style('whook-test-frentend-style', whook_test_plugin_url."css/frentend-style.css");
    wp_enqueue_script('whook-test-validate-js', whook_test_plugin_url.'js/jquery.validate.min.js');
    wp_enqueue_script('whook-test-additional-js', whook_test_plugin_url.'js/additional-methods.min.js');
	
    wp_enqueue_script('whook-test-prettyfile-script', whook_test_plugin_url.'js/bootstrap-prettyfile.js');
    wp_enqueue_script('whook-test-jpreview-script', whook_test_plugin_url.'js/jpreview.js');
	
	wp_enqueue_script('whook-test-frentend-script', whook_test_plugin_url.'js/frentend-script.js');
}
add_action('wp_footer','whook_test_frontend_scripts');

function whook_test_recaptcha_js() {
	wp_enqueue_script('whook-test-recaptcha-js','https://www.google.com/recaptcha/api.js');
}

function whook_test_about_us()
{
?>
<div class="col-md-12 nopadding logo-area">
<img src="<?php echo whook_test_plugin_url."images/logo.png"?>" class="img-responsive pull-right logo-img">
</div>
<?php
}
/* start question code*/

function whook_test_question_table_show()
{
    if(!class_exists('whook_test_list')) {
	   include(whook_test_path.'whook-class/dtlist-class.php');
    }
	$dtlist = new whook_test_list();
	whook_test_about_us();
	$dtlist->whook_test_question_table_show();
}

function whook_test_settings_show()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   if(!class_exists('whook_test_form')) {
   include(whook_test_path.'whook-class/form-class.php');
   }
   $form = new whook_test_form();
   $form->dtobj = $WhookTestimonial; 
   whook_test_about_us();
   $form->whook_test_settings_showfrm();
}

function whook_test_setting_update()
{
   if(!class_exists('WhookTestimonial')) {
   include(whook_test_path.'whook-class/dbtask-class.php');
   }
   $WhookTestimonial = new WhookTestimonial();
   $WhookTestimonial->update_settings();
}
add_action('wp_ajax_whook_test_setting_update','whook_test_setting_update');


function whook_test_question_table_list()
{
	include(whook_test_path.'whook-class/dtlist-class.php');
	$dtlist =  new whook_test_list();
	$dtlist->get_question_table();
}
add_action('wp_ajax_whook_test_question_table_list','whook_test_question_table_list');

function whook_test_whook_test_question_updatefrm()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   include(whook_test_path.'whook-class/form-class.php');
   $form = new whook_test_form();
   $form->dtobj = $WhookTestimonial;
   $form->show_whook_test_whook_test_question_updatefrm();
}
add_action('wp_ajax_whook_test_whook_test_question_updatefrm','whook_test_whook_test_question_updatefrm');

function whook_test_question_update()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   $WhookTestimonial->update_question();
}
add_action('wp_ajax_whook_test_question_update','whook_test_question_update');


function whook_test_question_add()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   $WhookTestimonial->add_new_question();
}
add_action('wp_ajax_whook_test_question_add','whook_test_question_add');


/* end question code*/


function whook_delete_image()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   $WhookTestimonial->whook_delete_image();
}
add_action('wp_ajax_whook_delete_image','whook_delete_image');

function whook_test_delete_testimonial()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   global $wpdb;
   $table_name = $wpdb->prefix.'dweb_message';
   $WhookTestimonial->delete_data($table_name);
}
add_action('wp_ajax_whook_test_delete_testimonial','whook_test_delete_testimonial');


function whook_test_delete_question()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   global $wpdb;
   $table_name = $wpdb->prefix.'dweb_question';
   $WhookTestimonial->delete_data($table_name);
}
add_action('wp_ajax_whook_test_delete_question','whook_test_delete_question');


function whook_test_update_testimonial()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   $WhookTestimonial->whook_test_update_testimonial();
}
add_action('wp_ajax_whook_test_update_testimonial','whook_test_update_testimonial');

function whook_test_update_frm()
{
   include(whook_test_path.'whook-class/dbtask-class.php');
   $WhookTestimonial = new WhookTestimonial();
   include(whook_test_path.'whook-class/form-class.php');
   $form = new whook_test_form();
   $form->dtobj = $WhookTestimonial;
   $form->whook_test_update_frm();
}
add_action('wp_ajax_whook_test_update_frm','whook_test_update_frm');


function whook_whook_test_table_show(){
	include(whook_test_path.'whook-class/dtlist-class.php');
	$dtlist =  new whook_test_list();
	whook_test_about_us();
	$dtlist->whook_test_table_show();
}

function whook_test_table()
{
	include(whook_test_path.'whook-class/dtlist-class.php');
	$dtlist =  new whook_test_list();
	$dtlist->get_whook_test_table();
}
add_action('wp_ajax_whook_test_table','whook_test_table');

function whook_test_submit_form()
{
	include(whook_test_path.'whook-class/dbtask-class.php');
	$WhookTestimonial = new WhookTestimonial();
	$WhookTestimonial->whook_test_submit_form();
}
add_action('wp_ajax_nopriv_whook_test_submit_form','whook_test_submit_form');
add_action('wp_ajax_whook_test_submit_form','whook_test_submit_form');


function whook_test_feedback_show( $atts ) {
$atts = shortcode_atts(
	array(
		'limit' => '',
		'layout' => '',
	), $atts, 'whook_test_form' );	
ob_start();
if(!class_exists('WhookTestimonial')) {
include(whook_test_path.'whook-class/dbtask-class.php');
}
$WhookTestimonial = new WhookTestimonial();
if(!class_exists('whook_test_form')) {
include(whook_test_path.'whook-class/form-class.php');
}
$form = new whook_test_form();
$form->dtobj = $WhookTestimonial;
$form->whook_test_show_testimonial($atts['limit'],$atts['layout']);

return ob_get_clean();
}

function whook_test_form( $atts ) {
    ob_start();
	if(!class_exists('WhookTestimonial')) {
	include(whook_test_path.'whook-class/dbtask-class.php');
	}
	$WhookTestimonial = new WhookTestimonial();
    
	if(!class_exists('whook_test_form')) {
	include(whook_test_path.'whook-class/form-class.php');
	$form = new whook_test_form();
		}
	$form->dtobj = $WhookTestimonial;
	$setting = $WhookTestimonial->get_setting();
	if($setting[0]->setting_recaptcha_enable==1)
	{
		 add_action('wp_footer','whook_test_recaptcha_js');
	}
	$form->whook_test_show_form($setting);
    return ob_get_clean();
}
add_shortcode('whook-test-form', 'whook_test_form' );
add_shortcode('whook-test-feedback-show', 'whook_test_feedback_show' );
?>