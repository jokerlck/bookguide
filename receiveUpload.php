<?php
	error_reporting(E_ERROR);
	if (isset($_FILES['image'])){
		header('Content-Type: application/json; charset=utf-8');
		$output = array();
		$target_dir = "data/upload/";
		$target_file = $target_dir . date("YmdHis")."_".basename($_FILES["image"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES["image"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	    	$output['error'] = "File is not an image.";
	        $uploadOk = 0;
	    }

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	    	$output['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    	$uploadOk = 0;
	    }

	    if ($uploadOk != 0) {
		    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		    	chmod($target_file,0644);
		    } else {
		        $output['error'] = "Sorry, there was an error uploading your file.";
		    }
		}

		

		$json_string = json_encode($output);
		echo $json_string;
	}		
?>