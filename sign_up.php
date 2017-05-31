<?php
	require('lib/db.connect.php');
	require('lib/Password.php');

	if (isset($_POST['submit'])){

		$stmt = $db->prepare('SELECT COUNT(*) FROM `User` WHERE Email=? OR Contact=?');
		$stmt->bindValue(1, $_POST['email']);
		$stmt->bindValue(2, $_POST['contact']);
		$stmt->execute();
		$result = $stmt->fetch();
		$result = $result['COUNT(*)'];
		if ($result > 0)
			header("Location: sign_up.php?duplicateUsername=1");
		else{
			$email_hash = md5(rand()."Bookguide".$_POST['email'].time());

			$stmt = $db->prepare('INSERT INTO `User` (`FirstName`, `LastName`, `Email`, `Salt`, `Hash`, `Gender`, `Contact`, `District`, `Nickname`, `verified`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->bindValue(1, $_POST['first_name']);
			$stmt->bindValue(2, $_POST['last_name']);
			$stmt->bindValue(3, $_POST['email']);
			list($hash, $salt) = Password::encrypt($_POST['password']);
			$stmt->bindValue(4, $salt);
			$stmt->bindValue(5, $hash);
			$stmt->bindValue(6, $_POST['gender']);
			$stmt->bindValue(7, $_POST['contact']);
			$stmt->bindValue(8, $_POST['district']);
			$stmt->bindValue(9, $_POST['nickname']);
			$stmt->bindValue(10, $email_hash);
			$stmt->execute();

			$mail_content = "Hi,\n\n";
			$mail_content .= "Welcome to Bookguide! To verify your e-mail address, please click the URL below:\n";
			$mail_content .= "http://bookguide.jaar.ga/verify.php?email=".$_POST['email']."&hash=".$email_hash."\n\n";
			$mail_content .= "Best Regards,"."\n";
			$mail_content .= "Bookguide Team"."\n";

			mail($_POST['email'],
				"Verify your e-mail address",
				$mail_content,
				"From: \"Bookguide\" <noreply@bookguide.jaar.ga>\r\n"
			);
			header("Location: wait_verify.php");
		}
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
		<link href='css/sign_up.css' rel='stylesheet' type='text/css'>

		<title>Sign Up - Bookguide</title>
	</head>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular-messages.js"></script>
	<body >
		<div class="container">
			<div class="row main">
				<div class="main-login main-center" ng-app="myApp"  ng-controller="myctrl as in">
				<h2>Sign up to read.</h2><br>
				<?php if (isset($_GET['duplicateUsername'])):?>
					<div class="alert alert-danger">
						Email and/or Mobile Phone have already been registered.
					</div>
				<?php endif; ?>

					<form action="#" name="form" method="post" id="login-form" role="form" >

						<div class="form-group" >
							<label for="name" class="cols-sm-2 control-label">First Name</label>
							<div class="cols-sm-10" >
								<div class="input-group" ng-class="{'has-error': form.first_name.$invalid && form.first_name.$touched}">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="first_name" id="first_name" data-ng-model='in.user.firstname'  placeholder="Enter your First Name" required/>
							  </div>
						  </div>
						</div>

					<div class="form-group">
					  <label for="name" class="cols-sm-2 control-label">Last Name</label>
					  <div class="cols-sm-10">
						<div class="input-group" ng-class="{'has-error': form.last_name.$touched && form.last_name.$error.required}">
						  <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
						  <input type="text" class="form-control" name="last_name" id="last_name" data-ng-model='in.user.lastname' placeholder="Enter your Last Name" required/>
						</div>
					  </div>
					</div>


						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group" ng-class="{'has-error': form.email.$touched  && form.email.$invalid}">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" name="email" id="email" data-ng-model='in.user.email'  placeholder="Enter your Email" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="nickname" class="cols-sm-2 control-label">Nickname</label>
							<div class="cols-sm-10">
								<div class="input-group" ng-class="{'has-error': form.nickname.$touched && form.nickname.$error.required}">
									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="nickname" id="nickname"  placeholder="Enter your Nickname" data-ng-model='in.user.nickname' required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group" ng-class="{'has-error': form.password.$touched && form.password.$error.required}">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" data-ng-model='in.user.password' required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group" ng-class="{'has-error': form.confirm.$touched && form.confirm.$invalid}">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password" data-ng-model='in.user.comfirm' required compare-to='in.user.password'/>
								</div>
				<div ng-Messages="form.confirm.$error" >
				  <div ng-message="compareTo">Must match the previous entry</div>
				</div>
							</div>
						</div>

				<div class="form-group">
						<label for="contact" class="cols-sm-2 control-label">Contact</label>
						<div class="cols-sm-10">
							<div class="input-group" ng-class="{'has-error': form.contact.$touched && (form.contact.$error.required || form.contact.$invalid)}">
								<span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
								<input type="text" class="form-control" name="contact" id="contact"  placeholder="Enter your Contact Number" data-ng-model='in.user.contact' required/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="gender" class="cols-sm-2 control-label">Gender</label>
						<div class="cols-sm-10">
							<div class="input-group" ng-class="{'has-error': form.district.$touched && form.gender.$error.required}">
								<span class="input-group-addon"><i class="fa fa-transgender" aria-hidden="true"></i></span>
								<select class="form-control" name="gender" id="gender" data-ng-model='in.user.gender' placeholder="Choose your Gender" required>
									<option value="M">Male</option>
									<option value="F">Female</option>
									<option value="O">Others</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="district" class="cols-sm-2 control-label">District</label>
						<div class="cols-sm-10">
							<div class="input-group" ng-class="{'has-error': form.district.$touched && form.district.$error.required}">
								<span class="input-group-addon"><i class="fa fa-map-marker fa" aria-hidden="true"></i></span>
								<select class="form-control" name="district" id="district" data-ng-model='in.user.district' placeholder="Choose your District" required>
									<option disabled>-----Hong Kong Island-----</option>
									<option value="Eastern">Eastern</option>
									<option value="Wan Chai">Wan Chai</option>
									<option value="Southern">Southern</option>
									<option value="Central and Western">Central and Western</option>

									<option disabled>-----Kowloon-----</option>
									<option value="Sham Shui Po">Sham Shui Po</option>
									<option value="Yau Tsim Mong">Yau Tsim Mong</option>
									<option value="Kowloon City">Kowloon City</option>
									<option value="Wong Tai Sin">Wong Tai Sin</option>
									<option value="Kwun Tong">Kwun Tong</option>

									<option disabled>-----New Territories-----</option>
									<option value="North">North</option>
									<option value="Tai Po">Tai Po</option>
									<option value="Sha Tin">Sha Tin</option>
									<option value="Sai Kung">Sai Kung</option>
									<option value="Tuen Mun">Tuen Mun</option>
									<option value="Yuen Long">Yuen Long</option>
									<option value="Tsuen Wan">Tsuen Wan</option>
									<option value="Kwai Tsing">Kwai Tsing</option>
									<option value="Islands">Islands</option>
								</select>
							</div>
						</div>
					</div>





						<div class="form-group ">
							<button type="submit" name="submit" id="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
						</div>

			<div class="form-group">
			  <div id="expand-box-header">
				<table width="100%">
				  <tr>
					<td style="color: white">Already have an account? <a href="sign_in.php" style="color: white">Sign in</a></td>
					<td style="text-align:right"><a href="index.htm" class="btn"> <i class="icon-rotate icon-flipped glyphicon glyphicon-share-alt"></i></a></td>
				  </tr>
			  </div>
			</div>

					</form>
				</div>
			</div>
		</div>
		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="//code.angularjs.org/1.6.0/angular-route.min.js"></script>
	<script src="//code.angularjs.org/1.6.0/angular-cookies.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="js/sign_up.js"></script>
	</body>
</html>
