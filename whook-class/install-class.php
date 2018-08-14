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
class whook_test_install
{
public function create_table()
{
	global $wpdb;
	$dweb_message = $wpdb->prefix.'dweb_message';
    // create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$dweb_message'") != $dweb_message) 
	{
		$sql = "CREATE TABLE IF NOT EXISTS `$dweb_message` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`msg_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_email` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_mobile` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_city` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_message` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_profile_image` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_question_ans` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_question` longtext NOT NULL,
				`msg_question_option` longtext NOT NULL,
				`msg_rating` int(1) NOT NULL,
				`msg_show_rating` int(1) NOT NULL,
				`msg_state` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_visite_date` date NOT NULL,
				`msg_status` int(1) NOT NULL COMMENT '0=active , 1=inactive',
				`msg_ip_address` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_browser` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
				`msg_update_date` datetime NOT NULL,
				`msg_submit_date` datetime NOT NULL,
			   PRIMARY KEY (`id`)
			)";
		dbDelta($sql);
	}

	$dweb_setting = $wpdb->prefix.'dweb_setting';
    // create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$dweb_setting'") != $dweb_setting) 
	{
		$sql = "CREATE TABLE IF NOT EXISTS `$dweb_setting`(
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `setting_to` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `setting_from` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `setting_subject` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `setting_mail_enable` varchar(10) NOT NULL,
			  `setting_input_field` longtext NOT NULL,
			  `setting_rating_type` varchar(5) NOT NULL,
			  `setting_rating_number` varchar(300) NOT NULL,
			  `setting_rating_words` varchar(300) NOT NULL,
			  `setting_form_layout` varchar(10) NOT NULL,
			  `setting_recaptcha_enable` varchar(10) NOT NULL,
			  `setting_recaptcha_key` varchar(300) NOT NULL,
			  `setting_recaptch_script` varchar(300) NOT NULL,
			  `setting_feedback_layout` varchar(10) NOT NULL,
			  `setting_rating_show` int(1) NOT NULL,
			  `setting_feedback_limit` varchar(10) NOT NULL,
			  `setting_feedback_showtype` varchar(10) NOT NULL,
			  `setting_feedback_showby` varchar(10) NOT NULL,
			   PRIMARY KEY (`id`)
			  )";
		dbDelta($sql);
   
        $query = "INSERT INTO `$dweb_setting` (`setting_to`, `setting_from`, `setting_subject`, `setting_mail_enable`, `setting_input_field`, `setting_rating_type`, `setting_rating_number`, `setting_rating_words`, `setting_form_layout`, `setting_recaptcha_enable`, `setting_recaptcha_key`, `setting_recaptch_script`, `setting_feedback_layout`, `setting_rating_show`, `setting_feedback_limit`, `setting_feedback_showtype`, `setting_feedback_showby`) VALUES
('your@email.com', 'FromName <your@email.com>', 'New Testimoninal', '1', 'a:7:{s:4:\"name\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}s:5:\"email\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}s:6:\"mobile\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}s:4:\"city\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}s:5:\"state\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}s:4:\"date\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}s:7:\"message\";a:2:{s:4:\"show\";s:1:\"1\";s:8:\"required\";s:1:\"1\";}}', '2', '1,2,3,4,5,6,7,8,9,10', 'a:4:{i:4;s:9:\"Excellent\";i:3;s:4:\"Good\";i:2;s:12:\"Satisfactory\";i:1;s:4:\"Poor\";}', '2', '', '', '', '1', '1', '5', '1', '2')";

        $wpdb->query($query);
		
	} 

	$dweb_question = $wpdb->prefix.'dweb_question';
    // create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$dweb_question'") != $dweb_question) 
	{
		$sql = "CREATE TABLE IF NOT EXISTS `$dweb_question` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `question` longtext COLLATE utf8_unicode_ci NOT NULL,
				  `question_status` int(1) NOT NULL COMMENT '0=actiive, 1=incative',
			       PRIMARY KEY (`id`)
				)";
		dbDelta($sql);
	} 
} 

} // end of class

?>