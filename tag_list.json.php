<?php
	require('lib/db.connect.php');
	header('Content-Type: application/json; charset=utf-8');
	$stmt = $db->prepare("SELECT DISTINCT Tag FROM `Hashtag`");
	$stmt->execute();
	$result = $stmt->fetchAll();
	$list = array();
	for ($i = 0; $i < count($result); $i++){
		array_push($list, $result[$i]['Tag']);
	}
	echo json_encode($list);
?>