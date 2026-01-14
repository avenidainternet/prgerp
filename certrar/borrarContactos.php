<?php
	include_once("conexion.php");
?>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
	<tr bgcolor="#CCCCCC">
		<td align="center" width="50%">Clientes			</td>
		<td align="center" width="50%">Sin<br>Clientes		</td>
	</tr>
		<?php	
			$link=Conectarse();
			$bdcc=mysql_query("SELECT * FROM contactosCli Order By RutCli");
			if($rowcc=mysql_fetch_array($bdcc)){
				do{
					if($rowcc['Email']){
						$bdcli=mysql_query("SELECT * FROM Clientes Where RutCli = '".$rowcc['RutCli']."'");
						if($rowcli=mysql_fetch_array($bdcli)){?>
							<tr>
								<td><?php echo $rowcli['Cliente'].'<br>'.$rowcc['Contacto'].'<br><b>'.$rowcc['Email'].'</b>'; ?></td>
								<td>&nbsp;</td>
							</tr>
							<?php
						}else{
							//$bdProv=mysql_query("DELETE FROM contactosCli WHERE RutCli = '".$rowcc['RutCli']."'");
							?>
							<tr>
								<td>&nbsp;</td>
								<td><?php echo $rowcc['Contacto'].'<br><b>'.$rowcc['Email'].'</b>'; ?></td>
							</tr>
							<?php
						}
					}
				}while ($rowcc=mysql_fetch_array($bdcc));
			}
			mysql_close($link);
		?>
</table>
