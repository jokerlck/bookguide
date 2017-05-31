<?php
	require_once('lib/db.connect.php');

	/*	*************************************************************
	 *
	 *	MODULE TO HANDLE MESSAGE SENDING
	 *
	 *	INPUT PARAMETERS:
	 *	-	$_POST['from']: ID of the current user
	 *	-	$_POST['to']: ID of the user to chat with (target user)
	 *	-	$_POST['msg']: message content
	 *
	 *	OUTPUT PARAMETERS: none
	 *
	 *	According to the input parameters,
	 *		the new message will be inserted to the Chat database.
	 *
	 *	*************************************************************/

	// Remove unnecessary spaces and html tags in the message content
	function handle_text($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$from = $_POST['from'];
	$to = $_POST['to'];
	$msg = handle_text($_POST['msg']);

	// Insert the new message into Chat database
	try {
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "
		INSERT INTO Chat (Sender, Receiver, Message)
		VALUES ('".$from."', '".$to."', '".$msg."');";
		$db->query($sql);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

?>