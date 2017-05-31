<?php
	require('lib/db.connect.php');
	require('lib/Password.php');

	session_start();
	if (isset($_SESSION['user']))
		header("Location: home.php");
	if (isset($_POST['submit'])){
		$stmt = $db->prepare('SELECT `Uid`, `Nickname`, `Email`, `Salt`, `Hash`, `Contact` FROM `User` WHERE `Email`=?');
		$stmt->bindValue(1, $_POST['email']);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if (count($result) > 0){
			$salt = $result[0]['Salt'];
			$hash = $result[0]['Hash'];
			$input = Password::validate($_POST['password'], $salt);
			if ($input == $hash){
				$_SESSION['user'] = $result[0]['Uid'];
				header("Location: home.php");
			}
		}
		header('Location:sign_in.php?error=1');
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
		<style type="text/css">
			/*
			/* Created by Filipe Pina
			 * Specific styles of signin, register, component
			 */
			/*
			 * General styles
			 */
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

			h1.title {
				font-size: 50px;
				font-family: 'Passion One', cursive;
				font-weight: 400;
			}

			hr{
				width: 10%;
				color: #fff;
			}

			.form-group{
				margin-bottom: 1em;
			}

			label{
				margin-bottom: 0em;
			}

			input,
			input::-webkit-input-placeholder {
			    font-size: 11px;
			    padding-top: 3px;
			}

			.main-login{
			 	background-color: #fff;
			    /* shadows and rounded borders */
			    -moz-border-radius: 2px;
			    -webkit-border-radius: 2px;
			    border-radius: 2px;
			    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			}
			.form-control {
			    height: auto!important;
			    padding: 8px 12px !important;
			}
			.input-group {
			    -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.21)!important;
			    -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.21)!important;
			    box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.21)!important;
			}
			#button {
			    border: 1px solid #ccc;
			    margin-top: 28px;
			    padding: 6px 12px;
			    color: #666;
			    text-shadow: 0 1px #fff;
			    cursor: pointer;
			    -moz-border-radius: 3px 3px;
			    -webkit-border-radius: 3px 3px;
			    border-radius: 3px 3px;
			    -moz-box-shadow: 0 1px #fff inset, 0 1px #ddd;
			    -webkit-box-shadow: 0 1px #fff inset, 0 1px #ddd;
			    box-shadow: 0 1px #fff inset, 0 1px #ddd;
			    background: #f5f5f5;
			    background: -moz-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
			    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f5f5f5), color-stop(100%, #eeeeee));
			    background: -webkit-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
			    background: -o-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
			    background: -ms-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
			    background: linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
			    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5', endColorstr='#eeeeee', GradientType=0);
			}
			.main-center{
			 	margin-top: 30px;
			 	margin: 0 auto;
			 	max-width: 400px;
			    padding: 10px 40px;
				background:#009edf;
				    color: #FFF;
			    text-shadow: none;
				-webkit-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			-moz-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
			}
			span.input-group-addon i {
			    color: #009edf;
			    font-size: 17px;
			}

			.login-button{
				margin-top: 5px;
			}

			.login-register{
				font-size: 11px;
				text-align: center;
			}
			.icon-flipped {
			  color: white;
			  transform: scaleX(-1);
			  -moz-transform: scaleX(-1);
			  -webkit-transform: scaleX(-1);
			  -ms-transform: scaleX(-1);
			}

		</style>
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

		<title>Sign In - Bookguide</title>

	</head>
	<body>
		<div class="container">
			<div class="row main">
				<?php if (isset($_GET['error'])):?>
				<div class="alert alert-danger">
					<?php if ($_GET['error'] == 1):?>
						Wrong email/password!
					<?php elseif ($_GET['error'] == 2):?>
						Please sign in first!
					<?php endif; ?>
				</div>
				<?php elseif (isset($_GET['registerSuccess'])):?>
				<div class="alert alert-success">
					Registeration was successful! Please login here.
				</div>
				<?php endif; ?>

				<div class="main-login main-center">
				<h2>Login to read.</h2><br>
					<form method="POST" id="login-form" action="#">

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" type="button submit" id="button" name="submit" class="btn btn-primary btn-lg btn-block login-button">Login</button>
						</div>

            <div class="form-group">
              <div id="expand-box-header">
                <table width="100%">
                  <tr>
                    <td style="color: white">No account? <a href="sign_up.php" style="color: white">Create one!</a></td>
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
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
