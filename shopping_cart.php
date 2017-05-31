<?php
	$page_config['title'] = 'Shopping Cart';
	$page_config['css'] = array('shopping_cart.css', 'grading.css','/lib/jquery-bar-rating/themes/bootstrap-stars.css');
	$page_config['js'] = array('/lib/jquery-bar-rating/jquery.barrating.min.js','grading.js','shopping_cart.js');
	include('template/main.php');
	function grade($id, $from){
		global $db;
		$stmt = $db->prepare("SELECT * FROM `Grade` WHERE `fromUser`=? AND `itemID`=?");
		$stmt->BindValue(1, $from);
		$stmt->BindValue(2, $id);
		$stmt->execute();
		$result = $stmt->fetch();
		if ($result){
			$result = $result['grade'];
		} else {
			$result = 0;
		}
		return $result;
	}

?>
<div class="container">
	<div class="content-body">
		<div class="col-lg-12 col-sm-12 main-box-container">
			<div class="box-head clearfix">
					<h1 class="pull-left">Buying</h1> <!--交易完左會自動由database delete-->
			</div>
			<br>
			<div class="box-content">
					<div class="table-container">
							<table id="products_buying" class="table table-hover">
									<thead>
											<tr>
													<th>Book Name</th>
													<th>Photo</th>
													<th>Price</th>
													<th>Seller</th>
													<th>Action</th>
											</tr>
									</thead>
								<tbody>
								<?php
									$stmt = $db->prepare("SELECT * FROM `Book` WHERE `Buyer`=? AND `Status`<>'c'");
									$stmt->BindValue(1, $_SESSION['user']);
									$stmt->execute();
									$results = $stmt->fetchAll();
								?>
									<?php foreach ($results as $result):?>
									<tr class="clickable-row" data-href="item.php?bid=<?php echo $result['Bid']; ?>">
										<td><span id="book<?php echo $result['Bid']; ?>"><?php echo $result['Bname'] ?></span></td>
										<td><img src="book_cover.php?id=<?php echo $result['Bid'] ?>&nopadding" class="book-thumbnail"></td>
										<td>HK$<?php echo $result['Price'] ?></td>
										<td><a href="profile.php?id=<?php echo $result['Seller']?>"><?php echo user_info($result['Seller'])['Nickname'] ?></a></td>
										<td>
											<?php switch ($result['Status']): ?><?php case 'r': ?>
											<select class="rating" data-current-rating="<?php echo grade($result['Bid'], $_SESSION['user'])?>">
												<option value=""></option>
												<?php for ($i = 1; $i <= 5; $i++): ?>
												<option value="<?php echo $i ?>"><?php echo $result['Bid'] ?>,<?php echo $result['Seller']?></option>
												<?php endfor; ?>
											</select>
											<?php break ?>
											<?php case 'a': ?>
												<button type="button" data-action="retreat" data-id="<?php echo $result['Bid'] ?>" class="btn btn-warning trade">Retreat</button>
											<?php break ?>
											<?php case 'u': ?>
												<button type="button" data-action="complete" data-id="<?php echo $result['Bid'] ?>" class="btn btn-primary trade">Transaction Complete</button>
											<?php break ?>
											<?php endswitch; ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
					</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="content-body">
		<div class="col-lg-12 col-sm-12 main-box-container">
			<div class="box-head clearfix">
					<h1 class="pull-left">Selling</h1> <!--交易完左會自動由database delete-->
			</div>
			<br>
			<div class="box-content">
					<div class="table-container">
						<table id="products_selling" class="table table-hover">
								<thead>
									<tr>
										<th>Book Name</th>
										<th>Photo</th>
										<th>Price</th>
										<th>Buyer</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$stmt = $db->prepare("SELECT * FROM `Book` WHERE `Seller`=? AND `Status` <> 'c'");
									$stmt->BindValue(1, $_SESSION['user']);
									$stmt->execute();
									$results = $stmt->fetchAll();
								?>
									<?php foreach ($results as $result):?>
									<tr class="clickable-row" data-href="item.php?bid=<?php echo $result['Bid']; ?>">
										<td><span id="book<?php echo $result['Bid']; ?>"><?php echo $result['Bname'] ?></span></td>
										<td><img src="book_cover.php?id=<?php echo $result['Bid'] ?>&nopadding" class="book-thumbnail"></td>
										<td>HK$<?php echo $result['Price'] ?></td>
										<?php if ($result['Buyer'] != NULL): ?>
										<td><a href="profile.php?id=<?php echo $result['Buyer']?>"><?php echo user_info($result['Buyer'])['Nickname'] ?></a></td>
										<?php else: ?>
										<td>N/A</td>
										<?php endif; ?>
										<td>
											<?php switch ($result['Status']): ?><?php case 'r': ?>
											<select class="rating" data-current-rating="<?php echo grade($result['Bid'], $_SESSION['user'])?>">
												<option value=""></option>
												<?php for ($i = 1; $i <= 5; $i++): ?>
												<option value="<?php echo $i ?>"><?php echo $result['Bid'] ?>,<?php echo $result['Buyer']?></option>
												<?php endfor; ?>
											</select>
											<?php break ?>
											<?php case 'a': ?>
												<?php if ($result['Buyer'] != NULL): ?>
													<button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="approve_buyer" class="btn btn-success trade">Approve</button>
													<button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="decline_buyer" class="btn btn-warning trade">Decline</button>
												<?php endif; ?>
												<button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="delete" class="btn btn-danger trade">Delete</button>
												


											<?php break ?>

											<?php case 'u': ?>
												<button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="complete" class="btn btn-primary trade">Transaction Complete</button>
											<?php break ?>

											<?php endswitch; ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
			</div>
		</div>
	</div>
</div>

<?php include('template/footer.php');?>
