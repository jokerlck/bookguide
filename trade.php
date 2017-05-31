<?php
	session_start();
	header('Content-Type: application/json; charset=utf-8');
	$output['success'] = false;
	if (isset($_GET['id']) && isset($_GET['action'])){
		require('lib/db.connect.php');
		switch ($_GET['action']){
			case 'approve_buyer':
				$stmt = $db->prepare("UPDATE `Book` SET `Status`='u' WHERE `Bid`=?");
				$stmt->BindValue(1, $_GET['id']);
				$stmt->execute();
				$output['success'] = true;
			break;

			case 'decline_buyer':
				$stmt = $db->prepare("UPDATE `Book` SET `Status`='a', `Buyer`=NULL  WHERE `Bid`=?");
				$stmt->BindValue(1, $_GET['id']);
				$stmt->execute();
				$output['success'] = true;
			break;

			case 'complete':
				$stmt = $db->prepare("UPDATE `Book` SET `Status`='r' WHERE `Bid`=?");
				$stmt->BindValue(1, $_GET['id']);
				$stmt->execute();
				$output['success'] = true;
			break;

			case 'buy':
				$stmt = $db->prepare("SELECT * FROM `Book` WHERE `Bid`=? AND `Buyer` IS NULL");
				$stmt->BindValue(1, $_GET['id']);
				$stmt->execute();
				$result = $stmt->fetch();
				if ($result){
					$stmt = $db->prepare("UPDATE `Book` SET `Buyer`=? WHERE `Bid`=?");
					$stmt->BindValue(1, $_SESSION['user']);
					$stmt->BindValue(2, $_GET['id']);
					$stmt->execute();
					$output['success'] = true;
				} else {
					$output['errorMsg'] = 'Book has been bought.';
				}
			break;

			case 'retreat':
				$stmt = $db->prepare("SELECT * FROM `Book` WHERE `Bid`=? AND `Buyer`=?");
				$stmt->BindValue(1, $_GET['id']);
				$stmt->BindValue(2, $_SESSION['user']);
				$stmt->execute();
				$result = $stmt->fetch();
				if ($result){
					$stmt = $db->prepare("UPDATE `Book` SET `Buyer`=NULL, `Status`='a' WHERE`Buyer`=? AND `Bid`=?");
					$stmt->BindValue(1, $_SESSION['user']);
					$stmt->BindValue(2, $_GET['id']);
					$stmt->execute();
					$output['success'] = true;
				} else {
					$output['errorMsg'] = 'You have not purchased this book.';
				}
			break;

			case 'delete':				
				$stmt = $db->prepare("DELETE FROM `Book` WHERE `Seller`=? AND `Bid`=?");
				$stmt->BindValue(1, $_SESSION['user']);
				$stmt->BindValue(2, $_GET['id']);
				$stmt->execute();
				$output['success'] = true;				
			break;

			default:
				$output['errorMsg'] = 'Action not defined';
			break;
		}
	}
	echo json_encode($output);
?>