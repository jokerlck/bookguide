<?php
	// Generating book cover image
	// Define basic height and width
	define('HEIGHT', 400);
	define('WIDTH', 270);

	if (isset($_GET['id'])){
		$photoID = 0;
		// Get photo_id from query string
		if (isset($_GET['photo_id']))
			$photoID = $_GET['photo_id'];
		require('lib/db.connect.php');
		$stmt = $db->prepare("SELECT `Bid`, `filename` FROM `Book` WHERE `Bid`=?");
		$stmt->BindValue(1, $_GET['id']);
		$stmt->execute();
		$result = $stmt->fetch();
		// Let default cover image as infile
		$infile = 'img/default_cover.png';
		// Get the first image if there is no specified photo id
		if ($result){
			if ($result['filename'] != ""){
				$filename = explode(",", $result['filename']);
				if ($photoID < count($filename)){
					$filename = $filename[$photoID];
					$infile = 'data/upload/'.$filename;
				}
			}
		}
		// Create gd image from infile
		$mime_type = mime_content_type($infile);
		switch ($mime_type){
			case 'image/jpeg':
				$raw_image = imagecreatefromjpeg($infile);
			break;
			case 'image/gif':
				$raw_image = imagecreatefromgif($infile);
			break;
			case 'image/png':
				$raw_image = imagecreatefrompng($infile);
			break;
			case 'image/x-windows-bmp':
				$raw_image = imagecreatefrombmp($infile);
			break;
		}

		if (!isset($_GET['nopadding'])){
			// If padding is not required
			$new_image = imagecreatetruecolor(WIDTH, HEIGHT);
			imagesavealpha($new_image, true);
			imagefill($new_image, 0, 0, 0x7F000000);
			imagealphablending($new_image, true);
			$raw_image = imagescale($raw_image, WIDTH);
			$oldw = imagesx($raw_image);
			$oldh = imagesy($raw_image);
			$xborder = max(0, (int)floor((WIDTH-$oldw)/2));
			$yborder = max(0, (int)floor((HEIGHT-$oldh)/2));
			$neww = min($oldw, WIDTH);
			$newh = min($oldh, HEIGHT);
			if (imagecopy($new_image, $raw_image, $xborder, $yborder, 0, 0, $neww, $newh)){
				header("Content-Type: image/png");
				imagepng($new_image, NULL, 3);
			}
		} else {
			// If padding is required
			header("Content-Type: image/jpeg");
			$new_width = min(imagesx($raw_image), 2000);
			$new_image = imagescale($raw_image, $new_width);
			imagejpeg($new_image, NULL, 80);
		}
	}
?>