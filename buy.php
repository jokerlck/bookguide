<?php
	session_start();
	// Let tis page output JSON Data
	header('Content-Type: application/json; charset=utf-8');
	require('lib/db.connect.php');
	$output['success'] = false;
	if (isset($_GET['id']) && isset($_SESSION['user'])){
		// Find the target book and check if the user is permitted to buy the book
		$stmt = $db->prepare("SELECT * FROM `Book` WHERE `Bid`=? AND `Buyer` IS NULL");
		$stmt->BindValue(1, $_GET['id']);
		$stmt->execute();
		$result = $stmt->fetch();
		if ($result){
			// Buy the book
			$stmt = $db->prepare("UPDATE `Book` SET `Buyer`=? WHERE `Bid`=?");
			$stmt->BindValue(1, $_SESSION['user']);
			$stmt->BindValue(2, $_GET['id']);
			$stmt->execute();
			$output['success'] = true;
		} else {
			// The book had been bought
			$output['errorMsg'] = 'Book had been bought.';

		}
	}
	// Output JSON string
	echo json_encode($output);
?>