<?php
	// Page parameters
	$page_config['title'] = '#'.$_GET['tag'];
	$page_config['css'] = array('hashtag.css');
	$page_config['js'] = array('hashtag.js');
	include('template/main.php');
?>
<div class="container">
	<h1>#<?php echo $_GET["tag"]?></h1>
	<?php
		// Find 50 books with the specified hashtag
		$stmt = $db->prepare("SELECT b.*, `User`.`Nickname` FROM `User` INNER JOIN (SELECT * FROM `Hashtag` INNER JOIN `Book` ON `Book`.`Bid`=`Hashtag`.`Book`) AS b ON b.`Seller` = `User`.`Uid` WHERE b.`Tag`=? AND b.`Status`='a' ORDER BY `PostTime` DESC LIMIT 50");
		$stmt->BindValue(1, $_GET["tag"]);
		$stmt->execute();
		$results = $stmt->fetchAll();
		if ($results):
	?>
	<table class="table table-hover">
		<thead>
			<th colspan="2">Name</th>
			<th>Author</th>
			<th>Seller</th>
		</thead>
		<tbody>
			<?php foreach ($results as $result):?>
			<!-- Detail of each book -->
			<tr class="clickable-row" data-href="item.php?bid=<?php echo $result['Book']?>">
				<td><img class="book-thumbnail" src="book_cover.php?id=<?php echo $result['Book']?>&nopadding"></td>
				<td><?php echo $result['Bname']?></td>
				<td><?php echo $result['Author']?></td>
				<td><a href="profile.php?id=<?php echo $result['Seller']?>"><?php echo $result['Nickname']?></a></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php else: ?>
		<h3>Book Not Found</h3>
	<?php endif; ?>

</div>
<?php include('template/footer.php'); ?>
