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

class whook_test_uploadfive
{
public function upload_file($files=array())
{
$uploads = wp_upload_dir();
$uploadDir = $uploads['basedir'].'/uploads-profile/';

if(!file_exists($uploadDir))
{
   mkdir($uploadDir);
}

$fileTypes = array('jpg','jpeg','png'); // Allowed file extensions

if(isset($files) && !empty($files)) {
	session_start();
	$file_name = $files['file']['name'];	
	$tempFile = $files['file']['tmp_name'];	

	$fileParts = pathinfo($file_name);
	$file_name  = uniqid().uniqid()."_profile.".$fileParts['extension'];          
	$targetFile = $uploadDir.$file_name;

		if(in_array(strtolower($fileParts['extension']), $fileTypes))
		{
	
				if(isset($_SESSION["profile_photo"]) && !empty($_SESSION["profile_photo"]))
				{
					$check_path = $uploadDir.$_SESSION["profile_photo"];
					if(file_exists($check_path))
					{
						@unlink($check_path);
					}
				}
				move_uploaded_file($tempFile, $targetFile);
				$_SESSION["profile_photo"] = $file_name;
		} else {
			// The file type wasn't allowed
			echo 'Invalid file type.';
		}
	}else
	{
	  die("Not Allow Access");
	}
}

}




?>