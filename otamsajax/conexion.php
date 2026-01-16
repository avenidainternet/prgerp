<?php 
	function Conectarse()
		{
			if (!($link=mysql_connect("localhost","root",""))){
			//if (!($link=mysql_connect("localhost","simet_artigas","86382165.10074437"))){
				echo "Error cenexion.";
				exit();
			}
			if (!mysql_select_db("simet_laboratorio",$link)){
			//if (!mysql_select_db("simet_laboratorio",$link)){
				echo "Error seleccionando la Base de Datos.";
				exit();
			}
			mysql_query("SET NAMES 'utf8'");
			return $link;
		}
?>