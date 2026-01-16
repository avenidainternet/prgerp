<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=iso-8859-1');
	date_default_timezone_set("America/Santiago");
?>
	
	<script>

		// Necesita Calibración
		$( "#necesitaCal" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
			var fCal  = document.form.fechaCal.value;
			var tProx  = document.form.tpoProxCal.value;
		  	var nCal = '';
			var tipo = typeof(fCal);
			
			if(tipo == "string"){
				tProx++;
				fAct.setDate(fAct.getDate());
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fAct = anno+sep+mes+sep+dia;
				fCal = fAct;
				$("#fechaCal").val(fAct);
			}
		  	if($input.is( ":checked" )){
				fCal = new Date(fCal);
				//tProx++;
				fCal.setDate(fCal.getDate()+parseInt(tProx));
				var anno	= fCal.getFullYear();
				var mes		= fCal.getMonth()+1;
				var dia		= fCal.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fCal = anno+sep+mes+sep+dia;
				nCal = 'on';
				tProx--;
				//$("#fechaProxCal").show();
		  	}else{
				fCal  = '0000-00-00';
				$("#fechaCal").val(fCal);
				tProx = '';
				nCal = 'off';
				//$("#fechaProxCal").hide();
		  	}
			$("#fechaProxCal").val(fCal);
			$("#tpoProxCal").val(tProx);
		  	//$("#nomEquipo").val(fAct);
		})

		$( "#fechaCal" ).change(function() {
			var $input = $( this );
			var fCal  = document.form.fechaCal.value;
			var tProx  = document.form.tpoProxCal.value;
			fCal = new Date(fCal);
			//var fCal = fCal.getFullYear() + '-' + (fCal.getMonth() + 1) + '-' + fCal.getDate();

				//fCal = new Date(fCal);
				tProx++;
				fCal.setDate(fCal.getDate()+parseInt(tProx));
				var anno	= fCal.getFullYear();
				var mes		= fCal.getMonth()+1;
				var dia		= fCal.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fCal = anno+sep+mes+sep+dia;
				nCal = 'on';
				//tProx--;

			$("#fechaProxCal").val(fCal);
			
		  	//$("#nomEquipo").val(fCal);
		})

		$( "#tpoProxCal" ).change(function() {
			var $input = $( this );
			var fCal  = document.form.fechaCal.value;
			var tProx  = document.form.tpoProxCal.value;
			fCal = new Date(fCal);
			//var fCal = fCal.getFullYear() + '-' + (fCal.getMonth() + 1) + '-' + fCal.getDate();

				//fCal = new Date(fCal);
				tProx++;
				fCal.setDate(fCal.getDate()+parseInt(tProx));
				var anno	= fCal.getFullYear();
				var mes		= fCal.getMonth()+1;
				var dia		= fCal.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fCal = anno+sep+mes+sep+dia;
				nCal = 'on';
				//tProx--;

			$("#fechaProxCal").val(fCal);
			
		  	//$("#nomEquipo").val(fCal);
		})

		// Necesita Verificación
		$( "#necesitaVer" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
			var fVer  = document.form.fechaVer.value;
			var tProx  = document.form.tpoProxVer.value;
		  	var nVer = '';
			var tipo = typeof(fVer);
			
			if(tipo == "string"){
				tProx++;
				fAct.setDate(fAct.getDate());
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fAct = anno+sep+mes+sep+dia;
				fVer = fAct;
				$("#fechaVer").val(fAct);
			}
		  	if($input.is( ":checked" )){
				fVer = new Date(fVer);
				//tProx++;
				fVer.setDate(fVer.getDate()+parseInt(tProx));
				var anno	= fVer.getFullYear();
				var mes		= fVer.getMonth()+1;
				var dia		= fVer.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fVer = anno+sep+mes+sep+dia;
				nVer = 'on';
				tProx--;
				//$("#fechaProxCal").show();
		  	}else{
				fVer  = '0000-00-00';
				$("#fechaVer").val(fVer);
				tProx = '';
				nVer = 'off';
				//$("#fechaProxCal").hide();
		  	}
			$("#fechaProxVer").val(fVer);
			$("#tpoProxVer").val(tProx);
		  	//$("#nomEquipo").val(fAct);
		})

		$( "#prgActividad" ).change(function() {
			var $input = $( this );
			var fPrg  = document.form.prgActividad.value;
			var tProx  = document.form.tpoProx.value;
			fVer = new Date(fPrg);
			
			tProx++;
			fVer.setDate(fVer.getDate()+parseInt(tProx));
			var anno	= fVer.getFullYear();
			var mes		= fVer.getMonth()+1;
			var dia		= fVer.getDate();
			var sep 	= '-';
			mes = (mes < 10) ? ("0" + mes) : mes;
			dia = (dia < 10) ? ("0" + dia) : dia;
			var fVer = anno+sep+mes+sep+dia;
			nVer = 'on';

			$("#fechaProxAct").val(fVer);
			
		  	//$("#Actividad").val(fVer);
		})

		$( "#tpoProx" ).change(function() {
			var $input = $( this );
			var fPrg  = document.form.prgActividad.value;
			var tProx  = document.form.tpoProx.value;
			fVer = new Date(fPrg);
			
			tProx++;
			fVer.setDate(fVer.getDate()+parseInt(tProx));
			var anno	= fVer.getFullYear();
			var mes		= fVer.getMonth()+1;
			var dia		= fVer.getDate();
			var sep 	= '-';
			mes = (mes < 10) ? ("0" + mes) : mes;
			dia = (dia < 10) ? ("0" + dia) : dia;
			var fVer = anno+sep+mes+sep+dia;
			nVer = 'on';

			$("#fechaProxAct").val(fVer);
			
		})

		// Necesita Mantención
		$( "#necesitaMan" ).change(function() {
			var $input = $( this );
			var fAct = new Date();
			var fTxt = fAct.getFullYear() + '-' + (fAct.getMonth() + 1) + '-' + fAct.getDate();
			var fMan  = document.form.fechaMan.value;
			var tProx  = document.form.tpoProxMan.value;
		  	var nMan = '';
			var tipo = typeof(fMan);
			
			if(tipo == "string"){
				tProx++;
				fAct.setDate(fAct.getDate());
				var anno	= fAct.getFullYear();
				var mes		= fAct.getMonth()+1;
				var dia		= fAct.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fAct = anno+sep+mes+sep+dia;
				fMan = fAct;
				$("#fechaMan").val(fAct);
			}
		  	if($input.is( ":checked" )){
				fMan = new Date(fMan);
				//tProx++;
				fMan.setDate(fMan.getDate()+parseInt(tProx));
				var anno	= fMan.getFullYear();
				var mes		= fMan.getMonth()+1;
				var dia		= fMan.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fMan = anno+sep+mes+sep+dia;
				nMan = 'on';
				tProx--;
				//$("#fechaProxCal").show();
		  	}else{
				fMan  = '0000-00-00';
				$("#fechaMan").val(fMan);
				tProx = '';
				nMan = 'off';
				//$("#fechaProxCal").hide();
		  	}
			$("#fechaProxMan").val(fMan);
			$("#tpoProxMan").val(tProx);
		  	//$("#nomEquipo").val(fAct);
		})

		$( "#fechaMan" ).change(function() {
			var $input = $( this );
			var fVe  = document.form.fechaMan.value;
			var tProx  = document.form.tpoProx.value;
			fMan = new Date(fMan);
			//var fCal = fCal.getFullYear() + '-' + (fCal.getMonth() + 1) + '-' + fCal.getDate();

				//fCal = new Date(fCal);
				tProx++;
				fMan.setDate(fMan.getDate()+parseInt(tProx));
				var anno	= fMan.getFullYear();
				var mes		= fMan.getMonth()+1;
				var dia		= fMan.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fMan = anno+sep+mes+sep+dia;
				nMan = 'on';
				//tProx--;

			$("#fechaProxMan").val(fMan);
			
		  	//$("#nomEquipo").val(fCal);
		})

		$( "#tpoProxMan" ).change(function() {
			var $input = $( this );
			var fMan  = document.form.fechaMan.value;
			var tProx  = document.form.tpoProxMan.value;
			fMan = new Date(fMan);
			//var fCal = fCal.getFullYear() + '-' + (fCal.getMonth() + 1) + '-' + fCal.getDate();

				//fCal = new Date(fCal);
				tProx++;
				fMan.setDate(fMan.getDate()+parseInt(tProx));
				var anno	= fMan.getFullYear();
				var mes		= fMan.getMonth()+1;
				var dia		= fMan.getDate();
				var sep 	= '-';
				mes = (mes < 10) ? ("0" + mes) : mes;
				dia = (dia < 10) ? ("0" + dia) : dia;
				var fMan = anno+sep+mes+sep+dia;
				nMan = 'on';
				//tProx--;

			$("#fechaProxMan").val(fMan);
			
		})

	</script>
	
	<?php
	include_once("conexion.php"); 
	$Rev 	= 0;
	$idVisita			= $_GET['idVisita'];
	$accion 			= $_GET['accion'];
	$fechaRegAct 		= date('Y-m-d');
	$encNew 			= 'Si';
	$Cliente			= '';
	$usrResponsable		= '';
	$Actividad			= '';
	$Conclusion			= '';
	
	if($idVisita == 0){
		$link=Conectarse();
		$bddCot=mysql_query("Select * From Visitas Order By idVisita Desc");
		if($rowdCot=mysql_fetch_array($bddCot)){
			$idVisita = $rowdCot['idVisita'] + 1;
		}else{
			$idVisita = 1;
		}
		mysql_close($link);
		$prgActividad	= date('Y-m-d');
	}else{
		$link=Conectarse();
		$bdCot=mysql_query("SELECT * FROM Visitas Where idVisita = '".$idVisita."'");
		if($rowCot=mysql_fetch_array($bdCot)){
			$RutCli				= $rowCot['RutCli'];
			$Actividad			= $rowCot['Actividad'];
			$Comentarios		= $rowCot['Comentarios'];
			
			$actRepetitiva		= $rowCot['actRepetitiva'];
			$prgActividad		= $rowCot['prgActividad'];
			$tpoProx			= $rowCot['tpoProx'];
			$tpoAvisoAct		= $rowCot['tpoAvisoAct'];
			$fechaRegAct		= $rowCot['fechaRegAct'];
			$Conclusion			= $rowCot['Conclusion'];

			$usrResponsable		= $rowCot['usrResponsable'];
			
			$bdCl=mysql_query("SELECT * FROM Clientes Where RutCli = '".$RutCli."'");
			if($rowCl=mysql_fetch_array($bdCl)){
				$Cliente = $rowCl['Cliente'];
			}
		}
		mysql_close($link);
		$encNew = 'No';
	}
?>

<style></style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaActividades.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/poster_teachers.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Registro de Visitas 
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'plataformaActividades.php';
									}
									echo '<a href="'.$prgLink.'" style="float:right;"><img src="../imagenes/no_32.png"></a>';
								?>
							</div>
						</span>
					</td>
				</tr>
				<tr>
				  	<td colspan="3" class="lineaDerBot">
					  	<strong style=" font-size:20px; font-weight:700; margin-left:10px;">
							Visita N° 
							<?php
								if($accion == 'Actualizar' or $accion == 'Borrar'){ 
									echo $idVisita;?>
									<input name="idVisita" 	id="idVisita" type="hidden" value="<?php echo $idVisita; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
									<?php
								}
								if($accion == 'Agrega'){ 
									?>
									<input name="idVisita" 	id="idVisita" type="text" value="<?php echo $idVisita; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" readonly />
									<?php
								}
							?>
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; ?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
				  <td colspan="3">
				  
						<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
                    		<tr bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px;">
                      			<td height="40" style="color:#FFFFFF; font-size:18px; font-weight:700;">
									Identificación del Cliente
								</td>
                    		</tr>
                    		<tr>
								<td style="border-bottom:1px dotted #000; font-weight:700;">Seleccione Cliente</td>
						  	</tr>
                    		<tr>
                      			<td>
									<input name="Cliente" type="text" maxlength="50" size="50" list="clie" value="<?php echo $Cliente; ?>" placeholder="Ingrese Cliente..." autofocus required/>
									<datalist id="clie">
										<?php
											$link=Conectarse();
											$bdProv=mysql_query("SELECT * FROM Clientes");
											if($row=mysql_fetch_array($bdProv)){
												do{?>
													<option value="<?php echo $row['Cliente']; ?>">
													<?php
												}while ($row=mysql_fetch_array($bdProv));
											}
										?>
									</datalist>
								</td>
                   			</tr>
                  		</table>
						
				  </td>
			  	</tr>
				<tr>
					<td colspan="3">
						<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
							<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
								<td colspan="3">
									Objetivo Visita 
								</td>
							</tr>

				<tr>
					<td width="54%" rowspan="5" class="lineaDerBot">
						<textarea name="Actividad" id="Actividad" cols="80" rows="5"><?php echo $Actividad; ?></textarea>
					</td>
					<td width="26%" valign="top" class="lineaDerBot"><span class="lineaDer">Responzable <br>
				      Visita</span>
					</td>
		      	</tr>
				<tr>
				  <td valign="top" class="lineaDerBot">
				  		<select name="usrResponsable" id="usrResponsable" style="font-size:12px; font-weight:700;">
                    	<option></option>
                    		<?php
								$link=Conectarse();
								$bdCli=mysql_query("SELECT * FROM Usuarios Order By usuario");
								if($rowCli=mysql_fetch_array($bdCli)){
									do{
										$loginRes = $rowCli['usr'];
										if($usrResponsable == $loginRes){
											echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}else{
											echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}
									}while ($rowCli=mysql_fetch_array($bdCli));
								}
								mysql_close($link);
							?>
                  	</select>
				  </td>
			  	</tr>


						</table>
					</td>
				</tr>
				<tr>
				  <td valign="top" class="lineaDer">&nbsp;</td>
			      <td valign="top" class="lineaDer">&nbsp;</td>
			  	</tr>
				<tr>
			  	<td colspan="3" class="lineaDerBot">
			  		
					<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="2">
								Registro Visita </td>
						</tr>
						<tr>
							<td width="80%" class="lineaDerBot">Conclusi&oacute;n</td>
							<td width="20%" class="lineaDerBot">Fecha Visita  </td>
				      	</tr>
						<tr>
							<td class="lineaDerBot">
								<textarea name="Conclusion" id="Conclusion" cols="80" rows="10"><?php echo $Conclusion; ?></textarea>
							</td>
						  	<td class="lineaDerBot">
						    	<input name="fechaRegAct" id="fechaRegAct" type="date" value="<?php echo $fechaRegAct; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
					  	</tr>

					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="3" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' || $accion == 'Agrega' || $accion == 'Actualizar'){?>
							<div id="botonImagen">
								<button name="guardarActividad" style="float:right;" title="Guardar Registro de Visita">
									<img src="../gastos/imagenes/guardar.png" width="55" height="55">
								</button>
							</div>
							<?php
						}
						if($accion == 'Borrar'){?>
							<button name="confirmarBorrar" style="float:right;">
								<img src="../gastos/imagenes/inspektion.png" width="55" height="55">
							</button>
							<?php
						}
					?>
				</td>
		  </tr>
		</table>
		</form>
		</center>
	</div>
</div>

<script>
	$(document).ready(function(){
	  $("#CtaCte").click(function(){
		if($("#Cta").css("visibility") == "hidden" ){
			$("#Cta").css("visibility","visible");
		}else{
			$("#Cta").css("visibility","hidden");
		}
	  });
	});
</script>
