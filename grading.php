<?php
	session_start();
	require('lib/db.connect.php');
	// Find the grade of one side on certain transaction
	$stmt = $db->prepare("SELECT COUNT(*) FROM `Grade` WHERE `itemID`=? AND `toUser`=? ");
	$stmt->BindValue(1, $_GET['itemid']);
	$stmt->BindValue(2, $_GET['to']);
	$stmt->execute();
	if ($stmt->fetch()[0] == 0){
		// Insert a new grading entry
		$stmt = $db->prepare("INSERT INTO `Grade` (`fromUser`, `toUser`, `grade`, `itemID`) VALUES (?, ?, ?, ?)");
		$stmt->BindValue(1, $_SESSION['user']);
		$stmt->BindValue(2, $_GET['to']);
		$stmt->BindValue(3, $_GET['grade']);
		$stmt->BindValue(4, $_GET['itemid']);
		$stmt->execute();

		// Insert a new grading entry
		$stmt = $db->prepare("SELECT COUNT(*) FROM `Grade` WHERE `itemID`=?");
		$stmt->BindValue(1, $_GET['itemid']);
		$stmt->execute();
		$result = $stmt->fetch()[0];
		if ($result == 2){
			// Change the state of the transaction
			$stmt = $db->prepare("UPDATE `Book` SET `Status`='c' WHERE `Bid`=?");
			$stmt->BindValue(1, $_GET['itemid']);
			$stmt->execute();
		}		

	// Notify the user who was graded
    $sql_noti = "INSERT INTO Noti (FromUser, ToUser, Book, Type) VALUES (:from, :to, :book, 'G')";
		$stmt_noti = $db->prepare($sql_noti);
    $stmt_noti->bindValue(':from',$_SESSION['user']);
    $stmt_noti->bindValue(':to',$_GET['to']);
    $stmt_noti->bindValue(':book',$_GET['itemid']);
    $stmt_noti->execute();
	} else {
		// Update the grading
		$stmt = $db->prepare("UPDATE `Grade` SET `grade`=?  WHERE `itemID`=? AND `toUser`=? ");
		$stmt->BindValue(1, $_GET['grade']);
		$stmt->BindValue(2, $_GET['itemid']);
		$stmt->BindValue(3, $_GET['to']);
		$stmt->execute();
	}	
?>