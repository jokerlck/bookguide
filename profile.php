<?php
	/*	*************************************************************
	 *
	 *	MODULE TO HANDLE FOLLOW/UNFOLLOW
	 *
	 *	INPUT PARAMETERS:
	 *	-	$_GET['action']: Either follow/unfollow
	 *	-	$_SESSIO['user']: ID of the current user
	 *	-	$_GET['id']: ID of the user in the current profile
	 *
	 *	OUTPUT:
	 *	-	$output['success']: set to true if follow/unfollow database queries are executed
	 *		It will be used for further changes in follow buttons in profile.js
	 *
	 *	*************************************************************/
	if (isset($_GET['action'])){
		require('lib/db.connect.php');
  		require('lib/user_info.php');
  		session_start();
		header('Content-Type: application/json; charset=utf-8');
		$output['success'] = false;
		switch ($_GET['action']){
			case 'follow':
				// Perform follow action in database, then set success to TRUE for further actions in profile.js
				$stmt = $db->prepare('INSERT INTO `Follow` VALUES (?,?)');
				$stmt->bindValue(1, $_SESSION['user']);
				$stmt->bindValue(2, $_GET['id']);
				$stmt->execute();
				$output['success'] = true;
			break;
			case 'unfollow':
				// Perform unfollow action in database, then set success to TRUE
				$stmt = $db->prepare('DELETE FROM `Follow` WHERE `Follower`=? AND `Followee`=?');
				$stmt->bindValue(1, $_SESSION['user']);
				$stmt->bindValue(2, $_GET['id']);
				$stmt->execute();
				$output['success'] = true;
			break;
		}
		echo json_encode($output);
		exit();
	}
	$page_config['js'] = array('profile.js', 'redirect.js');
	include('template/main.php');
	require('lib/db.connect.php');

	$user = $_USER;
	if (isset($_GET['id'])){
		$temp_user = user_info($_GET['id']);
		if($temp_user)
			$user = $temp_user;
	}
?>
<script>
var myid = <?php echo $_SESSION['user']; ?>;
var yourid = <?php echo $_GET['id']; ?>;
</script>
<div class="container">
	<div class="box-head clearfix">
			<h1 class="pull-left"><?php echo $user["Nickname"] ?>'s Profile</h1> <!--name from database-->
	</div>
	<br>
	<div class="col-6 col-md-2">
			<img src="//www.gravatar.com/avatar/<?php echo md5(strtolower(trim($user['Email']))); ?>?s=200" alt="" class="img-circle" style="height: 10em;width: 10em;">  <!--Image field-->
	</div>
	<div class="col col-md-8">
		<table id="advance_search" class="table is-datatable dataTable">
			<tbody>
				<tr>
					<td>Name</td>
					<td><?php echo $user["Nickname"] ?></td>
				</tr>
				<tr>
					<td>District</td>
					<td><?php echo $user["District"] ?></td>
				</tr>
				<tr>
					<td>Contact</td>
					<td><?php echo $user["Contact"] ?></td>
				</tr>
				<tr>
					<td>Grade</td>
					<td>																												 <!--Calculate and display the average grade of user-->
						<?php
							$stmt = $db->prepare('SELECT AVG(grade) FROM `Grade` WHERE `toUser`=?');
							$stmt->bindValue(1,$user["Uid"]);
							$stmt->execute();
							$result = $stmt->fetch();
							$grade = $result['AVG(grade)'];
							if($grade > 0){																					 #correct to nearest 0.1
								printf("%.1f", $grade);
							}else{
								echo(0);
							}
						?>
						<span class="glyphicon glyphicon-star" aria-hidden="true" style="color:#FFDF38;"></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="myid" value="<?php echo $_SESSION["user"] ?>">
	<input type="hidden" id="yourid" value="<?php echo $_GET["id"] ?>">
	<div class="modal-footer">
		<?php
			if($_SESSION['user'] != $user["Uid"]):
				$stmt = $db->prepare('SELECT * FROM `Follow` WHERE `Follower`=? AND `Followee`=?');
				$stmt->bindValue(1,$_SESSION['user']);
				$stmt->bindValue(2,$user["Uid"]);
				$stmt->execute();
				$result = $stmt->fetch();

				if($result):
		?>
					<!--Display "Unfollow" button if you have followed the user-->
					<a data-action='unfollow' class="btn btn-default action" id="unfollow_btn">Unfollow</a>
				<?php else: ?>
					<!--Display "Follow" button if you haven't followed the user-->
					<a data-action='follow' class="btn btn-primary action" id="follow_btn">Follow</a>
				<?php endif; ?>
				<a href="msg.php?id=<?php echo $user["Uid"] ?>" class="btn btn-primary">Chat</a>
			<?php endif; ?>

	</div>
</div>
<br>
<!--Display what the user is selling-->
<div class="container">
	<div class="box">
		<div class="box-head clearfix">
				<h1 class="pull-left"><?php echo $user["Nickname"] ?> is Selling</h1>
		</div>
		<div class="box-content">
			<div class='list-group gallery'>
				<!--Fetch data and use for loop to generate the following-->
				<?php
					$stmt = $db->prepare('SELECT `Bid`,`Bname`,`filename` FROM `Book` WHERE `Seller`= ? AND `status` <> "c"');
					$stmt->bindValue(1, $user["Uid"]);
					$stmt->execute();
					$result = $stmt->fetchAll();
					if(sizeof($result) <= 0){
						echo '<h3>Nothing.</h3>';
					}
					else{																												 #create new div for each item
						$i = 0;
						foreach($result as $item){
							echo '<div class="col-sm-6 col-xs-12 col-md-4">';
							echo '<a class="thumbnail fancybox" rel="ligthbox" href="item.php?bid='.$result[$i]['Bid'].'">';
							echo '<img class="img-responsive" alt="" src="book_cover.php?id='.$result[$i]['Bid'].'" />';
							echo '<div class="text-right"><small class="text-muted">';
							if (strlen($item['Bname']) > 30)
								echo substr($item['Bname'], 0, 30).'...';
							else
								echo $item['Bname'];
							echo '</small></div></a></div>';
							$i++;
						}
					}
				?>
			</div>
		</div>
	</div>
</div>


<?php include('template/footer.php');?>
