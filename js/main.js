/*	*************************************************************
 *
 *	CONTROLLER FOR template/main.php
 *
 *	Input parameters:
 *	-	myid: ID of the current user (from template/main.php)
 *
 *	External modules called:
 *	-	noti_fetch.php
 *	
 *	Areas affected:
 *	-	#unseen_msg: Link to msg.php in menu box (top-right)
 *	-	#unseen_noti: Link to noti.php in menu box (top-right)
 *
 *	*************************************************************/

$(document).ready(function() {
	var unseenmsg;
	var unseennoti;

	// Update unseen msg and noti count
	function update() {
		$.getJSON("noti_fetch.php", {id:myid}, function(data) {
			unseenmsg = data['msg_cnt'];
			unseennoti = data['noti_cnt'];
			$('#unseen_msg').text(unseenmsg);
			$('#unseen_noti').text(unseennoti);
		});
	}

	// Update regularly and at initial time
	update();
	setInterval(update,2000);
})