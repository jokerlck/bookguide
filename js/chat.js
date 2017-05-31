/*	*************************************************************
 *
 *	CONTROLLER FOR msg.php
 *
 *	Input parameters:
 *	-	myid: ID of the current user
 *	-	yourid: ID of the selected user
 *		(The following are for sending out messages)
 *		-	#send_to: ID of the user you are sending messages to
 *		-	#msg_field: content of the message you are going to send
 *
 *	External modules called:
 *	-	msg_fetch.php
 *	-	msg_send.php
 *	
 *	Areas affected:
 *	-	#chat: chat content body (right side)
 *	-	#friend_list: list of users you have chatted with (left side)
 *	-	#chat_box: automatic scrolling
 *
 *	*************************************************************/

$(document).ready(function() {
	var height; // height of the messages of selected user (right side of the page)

	/*	*************************************************************
	 *
	 *	MODULE TO UPDATE MESSAGE CONTENT (right side of the page)
	 *	
	 *	Input parameters: myid, yourid
	 *
	 *	Output parameters: none
	 *
	 *	*************************************************************/
	function update_message(myid,yourid) {
		/*	If no user is selected:
		 *		Tell the user to select one to chat
		 */
		if (yourid == myid) {
			$('#chat').html('<h1 class="clearfix">Select a user to chat!</h1>');
		}

		/*	If a user is selected (yourid is not null or undefined, and not equal to myid):
		 *		Fetch all messages from msg_fetch.php
		 */
		else if (yourid != '' && yourid !== undefined) {
			$.getJSON("msg_fetch.php", {mode:'msg',me:myid,with:yourid}, function(data) {
				var html_code = "";
				/*	If there is any message between the two users:
				 *		display all messages
				 */
				if (data['message_count'] > 0){
					var yourimg = data['yourimg'];
					var myimg = data['myimg'];
					// Place all display content (HTML) into html_code
					$.each( data['messages'], function( index, entry ) {
						// Adjust the message box to left or right according to the sender
						if(entry['sender'] == data['myid']) {
							html_code += '<li class="right clearfix">';
							html_code += '<span class="chat-img pull-right">';
							html_code += '<img src="//www.gravatar.com/avatar/'+myimg+'?s=50" alt="User Avatar">';
						} else {
							html_code += '<li class="left clearfix">';
							html_code += '<span class="chat-img pull-left">';
							html_code += '<img src="//www.gravatar.com/avatar/'+yourimg+'?s=50" alt="User Avatar">';
						}
						html_code += '</span>';
						html_code += '<div class="chat-body clearfix">';
						// Indicate last message location
						if (index == data['messages'].length - 1)
							html_code += '<span id="last_msg"></span>';
						html_code += '<div class="header">';
						html_code += '<a href="profile.php?id='+entry['sender']+'">';
						html_code += '<strong class="primary-font">'+entry['nickname']+'</strong></a>';
						html_code += '<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> '+moment(entry['time'], "YYYY-MM-DD HH:mm:ss").fromNow()+'</small>';
						html_code += '</div>';
						html_code += '<p>'+entry['content']+'</p>';
						html_code += '</div>';
					});
				} 
				/*	Else:
				 *		State that there are no messages to the user
				 */
				else {
					html_code += '<p><h1 class="clearfix">No messages to '+data['nickname']+' yet!</h1></p>';
					html_code += '<p><h1 class="clearfix">Start chatting now.</h1></p>';
				}
				// Update message content (from html_code), enable the message field, and set the send_to hidden value
				$('#chat').html(html_code);
				$('#send_to').val(yourid);
				$('#msg_field').removeAttr('disabled');
			});
		}
		/*	If no user is selected:
		 *		Tell the user to select one to chat
		 */
		else {
			$('#chat').html('<h1 class="clearfix">Select a user to chat!</h1>');
		}
	}

	/*	*************************************************************
	 *
	 *	MODULE TO UPDATE FRIEND LIST (right side of the page)
	 *	
	 *	Input parameters: myid, yourid
	 *
	 *	Output parameters: none
	 *
	 *	*************************************************************/
	function update_fd_list(myid,yourid) {
		$.getJSON("msg_fetch.php", {mode:'fd',me:myid,with:yourid}, function(data) {			
			var html_code = "";
			// Place all display content (HTML) into html_code
			$.each( data['session_list'], function( index, entry ) {
				html_code += '<li id="'+entry['id']+'"';
				if (yourid !== undefined && yourid == entry['id'])
					html_code += ' class="active bounceInDown"';
				html_code += '>';
				html_code += '<a href="javascript:;" class="clearfix">';
				html_code += '<img src="//www.gravatar.com/avatar/'+entry['icon']+'?s=50" class="img-circle fd_list_icon">';
				html_code += '<div id="name" class="friend-name"><strong>'+entry['nickname']+'</strong></div>';
				html_code += '<div class="last-message text-muted"><span>';
				// If the last message is sent by current user, add a 'You: ' label
				if (entry['sender'] == myid)
					html_code += 'You: ';
				html_code += entry['message']+'</span>';
				html_code += '</div>';
				html_code += '<small class="time text-muted">'+moment(entry['time'], "YYYY-MM-DD HH:mm:ss").fromNow()+'</small>';
				// If there are >9 unseen messages, simplify unseen count as '9+' to save space
				if (entry['unseen_count'] > 0){
					html_code += '<small class="chat-alert label label-danger">';
					if (entry['unseen_count'] <= 9)
						html_code += entry['unseen_count'];
					else
						html_code += '9+';
					html_code += '</small>';
				}
				html_code += '</a>';
				html_code += '</li>';
			});
			// Update message content (from html_code)
			$('#friend_list').html(html_code);
		});
	}

	/*	*************************************************************	*/

	// Update message height
	function update_height() {
		height = $('#chat-box').prop("scrollHeight");
	}

	// Scroll to bottom of the message
	function scroll_to_bottom() {
		$("#chat-box").animate({ 
			scrollTop: height
		}, 1000); 
	}

	// Change message content according to the friend selected
	$('.friend-list').on('click','li',function() {
		yourid = $(this).attr('id');
		update_fd_list(myid,yourid);
		update_message(myid,yourid);
		update_height();
		setTimeout(scroll_to_bottom(),2000);
	});

	/*	*************************************************************
	 *
	 *	MODULE TO SEND NEW MESSAGES (bottom of the page)
	 *	
	 *	Triggered by: (either)
	 *	-	User submits #msg_form (e.g. when pressing enter inside the form)
	 *	-	User clicks the submit button
	 *	
	 *	Input parameters:
	 *	-	myid, yourid
	 *	-	#msg_field: message content
	 *
	 *	Procedures:
	 *	-	Call: msg_send.php to update database
	 *	-	Scroll chat body to bottom
	 *	-	Clear message field
	 *
	 *	*************************************************************/
	var send_to = $('#send_to').val();
	function submit() {
		var msg = $('#msg_field').val();
		if (msg != "") {
			$.post('msg_send.php',{from:myid,to:yourid,msg:msg},function(data,status) {
				update_fd_list(myid,yourid);
				update_message(myid,yourid);
				update_height();
				setTimeout(scroll_to_bottom(),2000);
			});
			$('#msg_field').val('');
		}
		return false;
	}
	$('#msg_form').submit(submit);
	$('#send_btn').click(submit);

	/*	*************************************************************	*/

	// Update friend list and messages once entered msg.php
	update_fd_list(myid,yourid);
	update_message(myid,yourid);
	setTimeout(scroll_to_bottom(),2000);

	// Update friend list and messages regularly
	setInterval(function() {
		update_fd_list(myid,yourid);
		update_message(myid,yourid);
		update_height();
	},2000);
});