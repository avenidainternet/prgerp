<?php 
	function ConectarseCert()
		{
			$linkc = new mysqli('localhost', 'root', '', 'certificados');
			$linkc->query("SET NAMES 'utf8'");
			return $linkc;
		}
?>