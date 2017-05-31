<?php
	$page_config['title'] = 'Message';
	$page_config['css'] = 'chat.css';
	require_once('lib/db.connect.php');
	include('template/main.php');
?>
<div class="container bootstrap snippet">
	<div class="row">
		<div id="fd-list-col" class="col-md-4 bg-white" style="overflow:auto">
	  		<div class="row border-bottom padding-sm" style="padding: 10px 0px;">
	  			<!--
				<div class="col-md-12">
				  <a class="btn btn-default btn-block">Write new message</a>
				</div>
				-->
			</div>
	<!-- =============================================================== -->
		<!-- member list -->
			<ul id="friend_list" class="friend-list">
				<li id="1" class="active bounceInDown">
					<a href="javascript:;" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>John Doe</strong></div>
						<div class="last-message text-muted">Hello, Are you there?</div>
						<small class="time text-muted">Just now</small>
						<small class="chat-alert label label-danger">1</small>
					</a>
				</li>
				<li id="3">
					<a href="javascript:;" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>Jane Doe</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">5 mins ago</small>
						<small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
					</a>
				</li>
				<li id="4">
					<a href="javascript:;" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_3.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>John Chung</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">Yesterday</small>
						<small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
					</a>
				</li>
				<li id="5">
					<a href="javascript:();" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>Sam Ho</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">Yesterday</small>
						<small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
					</a>
				</li>
				<li id="10">
					<a href="javascript:();" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>Ivan Kwong</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">Yesterday</small>
						<small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
					</a>
				</li>
				<li id="11">
					<a href="javascript:();" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_6.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>Joker Lung</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">Yesterday</small>
						<small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
					</a>
				</li>
				<li id="7">
					<a href="javascript:();" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_5.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>Ronald Chan</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">Yesterday</small>
						<small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
					</a>
				</li>
				<li id="6">
					<a href="javascript:();" class="clearfix">
						<img src="http://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
						<div id="name" class="friend-name"><strong>Jane Doe</strong></div>
						<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
						<small class="time text-muted">5 mins ago</small>
						<small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
					</a>
				</li>
			</ul>
		</div>
		<div class="hidden-md hidden-lg"><hr /></div>
	<!--=========================================================-->
		<!-- selected chat -->
	  	<div id="chat-list-col" class="col-md-8 bg-white">
			<div class="chat-message" overflow:auto">
				<ul id="chat" class="chat">
					<li class="left clearfix">
						<span class="chat-img pull-left">
							<img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
						</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">John Doe</strong>
								<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
							</div>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							</p>
						</div>
					</li>
					<li class="right clearfix">
						<span class="chat-img pull-right">
							<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
						</span>
						<div class="chat-body clearfix">
							<div class="header">
							<strong class="primary-font">Sarah</strong>
							<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
							</div>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
							</p>
					  	</div>
					</li>
					<li class="left clearfix">
						<span class="chat-img pull-left">
							<img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
						</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">John Doe</strong>
							 	<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
							</div>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							</p>
						</div>
					</li>
					<li class="right clearfix">
						<span class="chat-img pull-right">
						<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
					 	</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">Sarah</strong>
								<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
							</div>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
							</p>
						</div>
					</li>
					<li class="left clearfix">
						<span class="chat-img pull-left">
						<img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
						</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">John Doe</strong>
							 	<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
							</div>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							</p>
						</div>
					</li>
					<li class="right clearfix">
						<span class="chat-img pull-right">
						<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
						</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">Sarah</strong>
								<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
							</div>
							<p>
							 	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
							</p>
						</div>
					</li>
					<li class="right clearfix">
						<span class="chat-img pull-right">
						<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
						</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">Sarah</strong>
								<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
							</div>
							<p>
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at.
							</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="chat-box bg-white">
				<form id="msg_form" class="input-group">
					<input id="send_to" name="send_to" type="hidden" value="" />
					<input id="msg_field" name="msg" class="form-control border no-shadow no-rounded" placeholder="Type your message here" />
					<span class="input-group-btn">
						<button id="send_btn" class="btn btn-success no-rounded" type="button" />Send</button>
					</span>
				</form><!-- /input-group -->
			</div>
		</div>
	</div>
</div>

<?php include('template/footer.php');?>
