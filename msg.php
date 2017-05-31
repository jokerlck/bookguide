<?php
	$page_config['title'] = 'Message';
	$page_config['css'] = 'chat.css';
	$page_config['js'] = array('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js','chat.js');
	require_once('lib/db.connect.php');
	include('template/main.php');
?>
<script>
	// Get current user's and selected user's id
	var yourid;
	<?php if (isset($_GET['id'])): ?>
	yourid = <?php echo $_GET['id']; ?>;
	<?php endif; ?>
	var myid = <?php echo $_SESSION['user']; ?>
</script>
<div class="container bootstrap snippet">
	<div class="row">
		<div id="fd-list-col" class="col-md-4 bg-white" style="overflow:auto">
	  		<div class="row border-bottom padding-sm" style="padding: 10px 0px;"></div>
	<!-- =============================================================== -->
		<!-- member list -->
			<ul id="friend_list" class="friend-list">
			</ul>
		</div>
		<div class="hidden-md hidden-lg"><hr /></div>
	<!-- =============================================================== -->
		<!-- selected chat -->
	  	<div id="chat-list-col" class="col-md-8 bg-white">
	  		<!-- chat content -->
			<div id="chat-box" class="chat-message" style="overflow:auto">
				<ul id="chat" class="chat"></ul>
			</div>
			<!-- box to type message -->
			<div class="chat-box bg-white">
				<form id="msg_form" class="input-group">
					<input id="send_to" name="send_to" type="hidden" value="" />
					<input id="msg_field" name="msg" class="form-control border no-shadow no-rounded" placeholder="Type your message here" disabled="disabled" />
					<span class="input-group-btn">
						<button id="send_btn" class="btn btn-success no-rounded" type="button" />Send</button>
					</span>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include('template/footer.php');?>
