<?php
	require_once('lib/db.connect.php');
	require_once('lib/user_info.php');
	header('Content-Type: application/json; charset=utf-8');

	/*	*************************************************************
	 *
	 *	MODULE TO FETCH UNSEEN MSG & NOTI COUNTS
	 *
	 *	INPUT PARAMETERS:
	 *	-	$_GET['id']: ID of current user (me)
	 *
	 *	OUTPUT PARAMETERS:
	 *	-	$output['msg_cnt']: Number of unseen messages
	 *	-	$output['noti_cnt']: Number of unseen notifications
	 *
	 *	The whole $output[] will be encoded in json and passed back to the .js file (main.js) which calls this module.
	 *
	 *	*************************************************************/

	// Only work when $_GET['id'] exists
	if (!isset($_GET['id'])) {
		header('Location: error.php');
	} else {
		$myid = $_GET['id'];
	}

	// Get number of unseen messages from Chat database
	$sql_unseenmsg = "SELECT COUNT(*) AS cnt FROM Chat WHERE (Receiver = :myid AND Seen = 0);";
	$stmt_unseenmsg = $db->prepare($sql_unseenmsg);
	$stmt_unseenmsg->bindValue(':myid',$myid,PDO::PARAM_INT);
	$stmt_unseenmsg->execute();
	$rs_unseenmsg = $stmt_unseenmsg->fetch();
	$unseenmsg = $rs_unseenmsg['cnt'];
	if ($unseenmsg == 0) { $unseenmsg = ""; } else if ($unseenmsg > 9) { $unseenmsg = "9+"; }
	$output['msg_cnt'] = $unseenmsg;

	// Get number of unseen noti from Noti database
	$sql_unseennoti = "SELECT COUNT(*) AS cnt FROM Noti WHERE (ToUser = :myid AND Seen = 0);";
	$stmt_unseennoti = $db->prepare($sql_unseennoti);
	$stmt_unseennoti->bindValue(':myid',$myid,PDO::PARAM_INT);
	$stmt_unseennoti->execute();
	$rs_unseennoti = $stmt_unseennoti->fetch();
	$unseennoti = $rs_unseennoti['cnt'];
	if ($unseennoti == 0) { $unseennoti = ""; } else if ($unseennoti > 9) { $unseenmsg = "9+"; }
	$output['noti_cnt'] = $unseennoti;

	// Finally, return the json-encoded $output to the .js file
	echo json_encode($output);
?>

