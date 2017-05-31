<?php
	function user_info($user_id){
		$stmt = $GLOBALS['db']->prepare('SELECT * FROM `User` WHERE `Uid`=?');
		$stmt->bindValue(1, $user_id);
		$stmt->execute();
		return $stmt->fetch();
	}

	if (isset($_SESSION['user'])){
		$_USER = user_info($_SESSION['user']);
	}
?>