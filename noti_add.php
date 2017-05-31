<?php
	require('lib/db.connect.php');
  	session_start();
	header('Content-Type: application/json; charset=utf-8');

	/*	*************************************************************
	 *
	 *	MODULE TO ADD NOTIFICATIONS
	 *
	 *	INPUT PARAMETERS:
	 *	-	$_GET['mode']: Mode of the notification (see noti.php or comments below)
	 *	-	$_GET['me']: ID of the current user
	 *	-	$_GET['you']: ID of the latest user who is related to that notification
	 *	-	$_GET['book']: ID of the book related to that notification
	 *
	 *	OUTPUT:
	 *	-	$output['cnt']: number of undeleted, similar notifications
	 *	-	$output['status']: either "added" or "updated" according to the case
	 *	-	$output['success']: false (updated to true in caller)
	 *	
	 *	According to the $output['cnt'],
	 *		the new notification will be EITHER added to the Noti database, 
	 *		OR overwrite the similar one.
	 *
	 *	The whole $output[] will be encoded in json and passed back to the .js file which calls this module.
	 *
	 *	*************************************************************/

  	$output['success'] = false;
	$sql_check = "";	// SQL statement to check if undeleted, similar noti exists
	$sql_add = "";		// SQL statement to add a new noti
	$sql_update = "";	// SQL statement to update the similar noti

	$mode = $_GET['mode'];
	$me = $_GET['me'];
	$you = $_GET['you'];
	$book; if (isset($_GET['bid'])) { $book = $_GET['bid']; }

	// Perform respective database queries according to the noti mode
	switch($mode) {
		case 'F': // follow[F]
			$sql_check = "SELECT * FROM Noti WHERE (FromUser = :myid AND ToUser = :yourid AND Type = 'F');";
			$sql_add = "INSERT INTO Noti (FromUser, ToUser, Type) VALUES (:myid, :yourid, 'F');";
			$sql_update = "UPDATE Noti SET Seen = 0 WHERE (FromUser = :myid AND ToUser = :yourid AND Type = 'F')";
			break;
		default: // comment[C], can buy[S], graded[G], someone wants to buy[B]
			$sql_check = "SELECT * FROM Noti WHERE (Book = :bookid AND ToUser = :yourid AND Type = '".$mode."');";
			$sql_add = "INSERT INTO Noti (FromUser, ToUser, Book, Type) VALUES (:myid, :yourid, :bid, 'C');";
			$sql_update = "UPDATE Noti SET Seen = 0, FromUser = :myid WHERE (Book = :bookid AND ToUser = :yourid AND Type = 'C');";
			break;
	}
	
	// Prepare for check existing noti query
	$rs_check = $db->prepare($sql_check);
	$rs_check->bindValue(':myid',$me);
	$rs_check->bindValue(':yourid',$you);
	if($mode != 'F') { $rs_check->bindValue(':bookid',$book); }

	// Prepare for add new noti query
	$rs_add = $db->prepare($sql_add);
	$rs_add->bindValue(':myid',$me);
	$rs_add->bindValue(':yourid',$you);
	if($mode != 'F') { $rs_check->bindValue(':bookid',$book); }

	// Prepare for update similar noti query
	$rs_update = $db->prepare($sql_update);
	$rs_update->bindValue(':myid',$me);
	$rs_update->bindValue(':yourid',$you);
	if($mode != 'F') { $rs_check->bindValue(':bookid',$book); }

	// First check for similar noti, then add or update noti accordingly
	$rs_check->execute();
	$rs_num = $rs_check->fetchColumn();
	$output['cnt'] = $rs_num;
	if ($rs_num == 0) {
		$rs_add->execute();
  		$output['status'] = 'added';
	} else {
		$rs_update->execute();
  		$output['status'] = 'updated';
	}

	// Finally, return the json-encoded $output to the .js file
	echo json_encode($output);
?>