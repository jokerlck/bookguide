<?php
	require_once('lib/db.connect.php');
	require_once('lib/user_info.php');
	header('Content-Type: application/json; charset=utf-8');

	/*	*************************************************************
	 *
	 *	MODULE TO FETCH MESSAGE AND FRIEND LIST
	 *
	 *	INPUT PARAMETERS:
	 *	-	$_GET['me']: ID of current user (me)
	 *	-	$_GET['mode']: what to get (either 'fd': friend list or 'msg': messages from the selected one)
	 *	-	$_GET['with']: ID of the user to chat with
	 *
	 *	OUTPUT PARAMETERS:
	 *	-	$output['error']: error message in getting data (if any)
	 *	1.	In 'fd' mode:
	 *		-	$output['session_list']: array of information about users you've chatted with, including:
	 *										id, icon, nickname, number of unseen messages, as well as
	 *										last message with its time and sender
	 *		-	$output['with']: ID of the user to chat with
	 *	2.	In 'msg' mode:
	 *		-	$output['messages']: array of information about the messages between two users, including:
	 *									ID and nickname of the sender, time and content of the message
	 *		-	$output['myid']: ID of the current user (me)
	 *		-	$output['myimg']: email to current user's avatar image
	 *		-	$output['nickname']: nickname of the user you are chatting with
	 *									Note: used only when no chat records in between
	 *		-	$output['yourimg']: email to the avatar image of the user you are chatting with
	 *
	 *	The whole $output[] will be encoded in json and passed back to the .js file which calls this module.
	 *
	 *	*************************************************************/

	// Only work when $_GET['mode'] exists
	if (isset($_GET['mode'])){
		switch ($_GET['mode']){
			case 'fd': // Get friend list
				$myid = $_GET['me'];
				$sql_lastmsg = "
					SELECT USER, Sender, U.Nickname, U.Email, Message, ChatTime, Seen FROM(
						SELECT USER, Sender, Message, ChatTime, Seen FROM Chat
						JOIN (  SELECT USER, MAX(ChatTime) m
						    FROM ((  SELECT Cid, Receiver USER, ChatTime
						        FROM Chat
						        WHERE Sender = :myid)
						      UNION (
						        SELECT Cid, Sender USER, ChatTime
						        FROM Chat
						        WHERE Receiver = :myid)
						      ) t1
						    GROUP BY USER) t2
						ON ((Sender = :myid AND Receiver = USER) OR (Sender = USER AND Receiver = :myid))
						AND (ChatTime = m)
						ORDER BY ChatTime DESC
						)t3
					JOIN User U
					ON USER = U.Uid
					ORDER BY ChatTime DESC;";
				$sql_unseen = "
					SELECT COUNT(*) AS cnt FROM Chat
					WHERE (Sender = :yourid AND Receiver = :myid AND Seen = 0);";

				try {
					// Fetch all last messages
					$stmt = $db->prepare($sql_lastmsg);
					$stmt->bindValue(':myid',$myid,PDO::PARAM_INT);
					$stmt->execute();
					$resultSet = $stmt->fetchAll();
					if (isset($_GET['with']))
						$output['with'] = $_GET['with'];	
					$output['session_list'] = array();
					foreach($resultSet as $result) {
						// Get unseen messages count
						$stmt_unseen = $db->prepare($sql_unseen);
						$stmt_unseen->bindValue(':myid',$myid,PDO::PARAM_INT);
						$stmt_unseen->bindValue(':yourid',$result['USER'],PDO::PARAM_INT);
						$stmt_unseen->execute();
						$result_unseen = $stmt_unseen->fetch();
						// Store all related result to output
						$session_data['id'] = $result['USER'];
						$session_data['icon'] = md5(strtolower(trim($result['Email'])));
						$session_data['nickname'] = $result['Nickname'];
						$session_data['sender'] = $result['Sender'];
						$session_data['time'] = $result['ChatTime'];
						$session_data['unseen_count'] = $result_unseen['cnt'];
						$session_data['message'] = $result['Message'];
						array_push($output['session_list'], $session_data);
					}
				} catch (PDOException $e) {
					$output['error'] = 'Error: '.$e->getMessage();
				}
			break;
			case 'msg': // Get messages, according to the ID of the user you are chatting with
				$yourid = $_GET['with'];
				$myid = $_GET['me'];
				$yourimg = md5(strtolower(trim(user_info($_GET['with'])['Email'])));
				$myimg = md5(strtolower(trim(user_info($_GET['me'])['Email'])));
				$output['yourimg'] = $yourimg;
				$output['myimg'] = $myimg;
				$output['myid'] = $myid;
				$sql = "
					SELECT Cid, Sender, U.Nickname, Receiver, Message, ChatTime
					FROM Chat
					JOIN User U ON Sender = U.Uid
					WHERE (Sender = :myid AND Receiver = :yourid) OR (Sender = :yourid AND Receiver = :myid) ORDER BY ChatTime";
				try {
					// Try to fetch messages between the two users
					$stmt = $db->prepare($sql);
					$stmt->bindValue(':myid',$myid,PDO::PARAM_INT);
					$stmt->bindValue(':yourid',$yourid,PDO::PARAM_INT);
					$stmt->execute();
					$resultSet = $stmt->fetchAll();
					$rows = $stmt->rowCount();
					$output['message_count'] = $rows;
					if ($rows > 0) {
						// Show all messages between the two users to $output['messages']
						$currentRow = 1;
						$output['messages'] = array();
						foreach($resultSet as $result) {
							$message['sender'] = $result['Sender'];
							$message['time'] = $result['ChatTime'];
							$message['nickname'] = $result['Nickname'];
							$message['content'] = $result['Message'];
							array_push($output['messages'], $message);
						}
						// Set all related messages (sent by other and received by yourself) to be seen
						try { 
							$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql_setseen = "
								UPDATE Chat SET Seen = 1
								WHERE (Sender = ".$yourid." AND Receiver = ".$myid.")"; 
							$stmt_setseen = $db->prepare($sql_setseen);
							$stmt_setseen->execute();
						} catch(PDOException $e) {
							$output['error'] = 'Error: '.$e->getMessage();
						}
					} else {
						// Show that there is no message between the two users
						$sql = "SELECT Nickname FROM User WHERE Uid = :yourid;";
						try {
							$stmt = $db->prepare($sql);
							$stmt->bindValue(':yourid',$yourid,PDO::PARAM_INT);
							$stmt->execute();
							$result = $stmt->fetch();
							$output['nickname'] = $result['Nickname'];
						} catch(PDOException $e) {
							$output['error'] = 'Error: '.$e->getMessage();
						}
					}
				} catch(PDOException $e) {
					echo "Error: ".$e->getMessage();
				}
			break;
			default:
				header('Location: home.php');
			break;
		}
	} else {
		header('Location: home.php');
	}

	// Finally, return the json-encoded $output to the .js file
	echo json_encode($output);
?>
