<?php 
	function Conectarse()
		{
			$link = new mysqli('http://servidordata/127.0.0.1', 'root', '', 'simet_laboratorio');
			$link->query("SET NAMES 'utf8'");
			return $link;
		}
?>