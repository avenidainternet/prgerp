<?php 
	function Conectarse()
		{
			$link = new mysqli('localhost', 'root', '', 'simet_laboratorio');
			$link->query("SET NAMES 'utf8'");
			return $link;
		}
?>