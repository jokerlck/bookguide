</div>
</div>
</div>
<!--JavaScript-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
	<?php if (isset($page_config['js'])):?>
		<?php if (!is_array($page_config['js']))
			$page_config['js'] = array($page_config['js'])
		?>
		<?php foreach ($page_config['js'] as $js_file):?>
			<?php if (file_exists("js/".$js_file))
				$js_file = "js/".$js_file
			?>
<script type="text/javascript" src="<?php echo $js_file?>"></script>
		<?php endforeach;?>
	<?php endif;?>
</body>
</html>
