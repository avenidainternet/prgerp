<?php 
	function ConectarseMM()
		{
			if (!($linkMM=mysql_connect("localhost","mundomet","faor86382165"))){
			//if (!($link=mysql_connect("localhost","root",""))){
				echo "Error conectando a la base de datos.";
				exit();
			}
			if (!mysql_select_db("mundomet_metales",$linkMM)){
				echo "Error seleccionando la base de datos.";
				exit();
			}
			return $linkMM;
		}
?>