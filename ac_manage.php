<?php
if (isset($_POST['submit'])){
	session_start();

	// Redirect user if the session variable is not set
	if (!isset($_SESSION['user'])){
		header("Location: sign_in.php?error=2");
	}

	// Import db connection and password salting libraries
	require('lib/db.connect.php');
	require('lib/Password.php');

	// Determine which form has been submitted
	switch($_POST['formType']){
		// Editing the account information
		case 'edit_account':
			$stmt = $db->prepare('SELECT COUNT(*) FROM `User` WHERE Uid=?');
			$stmt->bindValue(1, $_SESSION['user']);
			$stmt->execute();
			$result = $stmt->fetch();
			$result = $result['COUNT(*)'];
			// Check if there is an account with the same Uid
			if ($result > 0){
				// Update the other information
				$stmt = $db->prepare('UPDATE `User` SET `Nickname`=?, `Contact`=? WHERE Uid=?');
				$stmt->bindValue(1, $_POST['nickname']);
				$stmt->bindValue(2, $_POST['contact']);
				$stmt->bindValue(3, $_SESSION['user']);
				$stmt->execute();
				// Update the password if new password has been set
				if ($_POST['newpw'] != ""){
					$stmt = $db->prepare('UPDATE `User` SET `Salt`=?, `Hash`=? WHERE Uid=?');
					list($hash, $salt) = Password::encrypt($_POST['newpw']);
					$stmt->bindValue(1, $salt);
					$stmt->bindValue(2, $hash);
					$stmt->bindValue(3, $_SESSION['user']);
					$stmt->execute();
				}
				// Redirect to success page
				header("Location: ac_manage.php?success=1");
			}
		break;

		// Deleting the book
		case 'delete_book':
			// Find the selected books to delete
			$delete_items = $_POST['delete_item'];
			foreach ($delete_items as $delete_item){
				$stmt = $db->prepare('DELETE FROM `Book` WHERE `Bid`=? AND `Seller`=?');
				$stmt->bindValue(1, $delete_item);
				$stmt->bindValue(2, $_SESSION['user']);
				$stmt->execute();
			}
			// Redirect to success page
			header("Location: ac_manage.php?success=2");
		break;
	}

}
?>


<?php
	// Setting page parameters
	$page_config['title'] = 'Account Management';
	$page_config['css'] = 'ac_manage.css';
	$page_config['js'] = array('ac_manage.js', '//ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular-messages.js');
	include('template/main.php');
	require('lib/Password.php');
?>
<div class="container">
	<div class="content-body">
		<div class="col-lg-12 main-box-container">
			<div class="box">
				<div class="box-head clearfix">
						<h1 class="pull-left">Your Account</h1>
				</div>
				<br>
				<?php if (isset($_GET['success'])):?>
				<div class="alert alert-success">
					<!-- Success Dialog -->
					<?php if ($_GET['success'] == "1"):?>
					Account Information Updated Successfully.
					<?php endif;?>
					<!-- Success Dialog -->
					<?php if ($_GET['success'] == "2"):?>
					Book Deleted Successfully.
					<?php endif;?>
				</div>
				<?php endif;?>
				<form method="POST" action="ac_manage.php" name="form" ng-app="myApp" ng-controller="myctrl as in">
				<input type="hidden" name="formType" value="edit_account">
				<div class="box-content">
					<div class="table-container">
						<!-- Displaying user information-->
						<table id="edit_account" class="table is-datatable dataTable">
							<tbody>
								<tr>
									<td>User Name</td>
									<td><input type="text" id="nickname" name="nickname" value="<?php echo $_USER['Nickname']; ?>" class="form-control" ></td>
								</tr>
								<tr>
									<!-- Obtaining icon from external API -->
									<td>Profile Picture</td>
									<td><img src="//www.gravatar.com/avatar/<?php echo md5(strtolower(trim($_USER['Email']))); ?>?s=200" alt="" class="img-circle" style="height: 10em;width: 10em;"><br>
									<h5>Set your avatar using <a href="//en.gravatar.com/connect/?source=_signup">Gravatar</a> now!</h5>
									</td>

								</tr>
								<tr>
									<td>Email</td>
									<td style="float:left;"><?php echo $_USER['Email']; ?></td>
								</tr>
								<tr>
									<td>Grade</td>
									<?php
										$stmt = $db->prepare('SELECT AVG(grade) FROM `Grade` WHERE `toUser`=?');
										$stmt->bindValue(1, $_SESSION['user']);
										$stmt->execute();
										$result = $stmt->fetch();
										$grade = $result['AVG(grade)'];
									?>
									<td style="float:left;"><?php printf("%.1f", $grade) ?> <span class="glyphicon glyphicon-star" aria-hidden="true" style="color:#FFDF38;"></span></td> <!--check from database-->
								</tr>
								<tr>
									<td>Contact</td>
									<td><input type="text" id="contact" name="contact" value="<?php echo $_USER['Contact']; ?>" class="form-control"></td>
								</tr>
								<tr ng-class="{'has-error': form.password.$invalid && form.password.$touched">
									<td>New Password</td>
									<td><input type="password" id="newpw" name="newpw" class="form-control" ng-model="in.password" name="password" ></td>
								</tr>
								<tr ng-class="{'has-error': form.confirm.$invalid && form.confirm.$touched}">
									<td>Confirm Password</td>
									<td><input type="password" id="confirmpw" placeholder="confirm password" class="form-control" ng-model="in.confirm" name="confirm" compare-to='in.password'>
										<div ng-if="form.confirm.$touched" ng-Messages="form.confirm.$error" >
										  <div ng-message="compareTo" style="color:red">Must match the previous entry</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
							<div class="modal-footer">
								<button ng-disabled="form.$invalid" name="submit" type="submit" class="btn btn-primary" id="submit">Save</button>
							</div>
					</div>
					</form>
			</div>
			<div class="box">
				<div class="box-head clearfix">
						<h1 class="pull-left">Your Products</h1>
				</div>
				<br>

				<div class="box-content">
					<?php
						// Getting book list
						$stmt = $db->prepare("SELECT * FROM `Book` WHERE Seller=? AND Status <> 'c'");
						$stmt->bindValue(1, $_SESSION['user']);
						$stmt->execute();
						$books = $stmt->fetchAll();
					?>
					<?php if (sizeof($books) > 0):?>
						<div class="table-container">
						<table id="products" class="table is-datatable">
							<thead>
								<tr>
									<th class="select-checkbox no-filter">Select</th>
									<th>Book Name</th>
									<th>Photo</th>
									<th>Price</th>
									<th>Date</th>
								</tr>
							</thead>
							<form method="POST" action="ac_manage.php" id="delete_form">
							<input type="hidden" name="formType" value="delete_book">
							<tbody>

								<?php foreach ($books as $book):
									if ($book['filename'] != '')
										$book_cover = explode(",", $book['filename'])[0];
								?>

									<tr>
										<td><input class="checkbox" type="checkbox" name="delete_item[]" value="<?php echo $book['Bid'] ?>"></td>
										<td><a href="item.php?bid=<?php echo $book['Bid'] ?>"><?php echo $book['Bname']?></a></td>
										<td>
										<?php if ($book['filename'] != ''):?>
										<img class="book_cover" src="data/upload/<?php echo $book_cover ?>">
										<?php else:?>
										<img class="book_cover" src="img/default_cover.png">
										<?php endif;?>
										</td>
										<td>$<?php echo $book['Price']?></td>
										<td><?php echo date("Y-m-d", strtotime($book['PostTime'])) ?></td>
									</tr>
								<?php endforeach; ?>
										</tbody>

								</table>
						</div>
				</div>
				<div class="modal-footer">
					<button name="submit" type="submit" class="btn btn-primary" id="delete">Delete</button>
				</div>
				</form>
			</div>
			<?php else: ?>
				<!-- The user has not put any product onto the website yet -->
				<em>You have no product yet...</em>
			<?php endif; ?>

		</div>

	</div>
</div>
<?php include('template/footer.php');?>
