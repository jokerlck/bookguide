<?php
	require('lib/db.connect.php');
	require('lib/Password.php');
	if (!isset($_GET["email"]) || !isset($_GET["hash"]))
		header("Location: index.php");
	$success = False;
	$stmt = $db->prepare('SELECT COUNT(*) FROM `User` WHERE Email=? AND Verified=?');
	$stmt->bindValue(1, $_GET['email']);
	$stmt->bindValue(2, $_GET['hash']);
	$stmt->execute();
	$result = $stmt->fetch();
	$result = $result['COUNT(*)'];
	if ($result > 0){
		$stmt = $db->prepare('UPDATE `User` SET Verified="1" WHERE Email=?');
		$stmt->bindValue(1, $_GET['email']);
		$stmt->execute();
		$success = True;
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Website CSS style -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!-- Website Font style -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
		<style>
			#playground-container {
				height: 500px;
				overflow: hidden !important;
				-webkit-overflow-scrolling: touch;
			}
			body, html{
			  height: 100%;
				background:url(img/blueSky.jpg) no-repeat center center fixed;
				font-family: 'Oxygen', sans-serif;
				background-size: cover;
			}

			.main{
				margin:50px 15px;
			}

			.main-center{
				margin-top: 30px;
				margin: 0 auto;
				max-width: 50em;
					padding: 10px 40px;
				background:#009edf;
						color: #FFF;
					text-shadow: none;
				-webkit-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			-moz-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			}

			h1.title {
				font-size: 50px;
				font-family: 'Passion One', cursive;
				font-weight: 400;
				padding-top: 3px;
			}
			.main-center{
				margin-top: 30px;
				margin: 0 auto;
				max-width: 50em;
					padding: 10px 40px;
					color: #FFF;
					text-shadow: none;
				-webkit-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			-moz-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			}
			.success{
				background:#009EDF;
			}
			.error{
				background:#FF6600;
			}

		</style>

		<title>Wait for Authentication - Bookguide</title>
	</head>
	<body>
	<div class="container">
		<div class="row main">
				<?php if ($success):?>																									<!--Direct to sign in page if no error-->
					<div class="main-center success">
					<h1>Registration Finally Successful!</h1>
					<h4>Login and search in the sea of books!</h4>
					<?php header('Refresh: 2; URL=http://bookguide.jaar.ga/sign_in.php'); ?>
				<?php else:?>																														<!--Direct to sign up page if there is an error-->
					<div class="main-center error">
					<h1>Registration Not Successful!</h1>
					<h4>Unknown error occured. Please contact administrator.</h4>
					<?php header('Refresh: 2; URL=http://bookguide.jaar.ga/sign_up.php'); ?>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
	</body>
</html>
