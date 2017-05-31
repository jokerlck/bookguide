$(document).ready(function() {
	// Triggered by chat button, redirect to chat page according to uid
	$('#chat_btn').click(function() {
		$.redirect('',{id:$uid});
	});

	// Triggered by follow or unfollow button
	$(".action").click(function(event){
		var button = $(event.target);
		var myid = $("#myid").val();
		var yourid = $("#yourid").val();
		var action = button.data("action");
		
		// Send follow/unfollow action back to profile.php, then add noti and toggle follow button
		$.getJSON("profile.php", {id:yourid, action:action}, function(data){
			switch (action) {
				case 'follow':
					// Add "follow" notification, then toggle the "follow" button
					if (data['success']){
						$.getJSON("noti_add.php", {mode:'F',me:myid,you:yourid}, function(data,success) {
							button.attr('class', 'btn btn-default action');
							button.data('action', 'unfollow');
							button.html('Unfollow');						
						});
					}
				break;
				case 'unfollow':
					// Toggle the "follow" button
					if (data['success']){
						button.html('Follow');
						button.attr('class', 'btn btn-primary action');
						button.data('action', 'follow');
					}
				break;
			}
		});
	})
});