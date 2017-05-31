<?php
	class Password{
		public static function encrypt($raw){
			$salt = rand();
			$salt = md5($salt);
			$hash = md5($salt.$raw);
			return array($hash, $salt);
		}

		public static function validate($input, $salt){
			return md5($salt.$input);
		}
	}
?>