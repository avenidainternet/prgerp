<?php 	
	session_start(); 
	header('Content-Type: text/html; charset=utf-8');
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

		$( "#fechaVer" ).change(function() {
			var $input = $( this );
			var fVe  = document.form.fechaVer.value;
			var tProx  = document.form.tpoProxVer.value;
			fVer = new Date(fVer);
			//var fCal = fCal.getFullYear() + '-' + (fCal.getMonth() + 1) + '-' + fCal.getDate();

				//fCal = new Date(fCal);
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
				//tProx--;

			$("#fechaProxVer").val(fVer);
			
		  	//$("#nomEquipo").val(fCal);
		})

		$( "#tpoProxVer" ).change(function() {
			var $input = $( this );
			var fVer  = document.form.fechaVer.value;
			var tProx  = document.form.tpoProxVer.value;
			fVer = new Date(fVer);
			//var fCal = fCal.getFullYear() + '-' + (fCal.getMonth() + 1) + '-' + fCal.getDate();

				//fCal = new Date(fCal);
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
				//tProx--;

			$("#fechaProxVer").val(fVer);
			
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
	include_once("../conexionli.php"); 
	
	$Rev 			= 0;
	$tipoEquipo 	= '';
	$usrResponsable = '';
	$lugar 			= '';
	$necesitaCal 	= '';
	$fechaCal 		= '0000-00-00';
	$tpoProxCal 	= '';
	$tpoAvisoCal 	= '';
	$necesitaVer 	= '';
	$fechaProxCal 	= '0000-00-00';
	$fechaVer 		= '0000-00-00';
	$tpoProxVer 	= '';
	$tpoAvisoVer 	= '';
	$fechaProxVer 	= '0000-00-00';
	$necesitaMan 	= '';
	$fechaMan 		= '0000-00-00';
	$tpoProxMan 	= '';
	$tpoAvisoMan 	= '';
	$fechaProxMan 	= '0000-00-00';
	$nomEquipo		= '';
	$nSerie			= '';
	$accion			= 'Agrega';
	$Referencia		= '';
	$FormularioVer	= '';
	$FormularioMan	= '';
	$FormularioCal	= '';
	
	if(isset($_GET['nSerie'])) { $nSerie 			= $_GET['nSerie']; 	}
	if(isset($_GET['accion'])) { $accion 			= $_GET['accion'];	}
	
	$fechaApertura 		= date('Y-m-d');
	$encNew = 'Si';

	if($accion == 'Agrega'){
		$nSerie			= '';
/*		
		$link=Conectarse();
		$bddCot=$link->query("Select * From equipos Order By nSerie Desc");
		if($rowdCot=mysqli_fetch_array($bddCot)){
			$nSerie = $rowdCot['nSerie'] + 1;
		}else{
		}
		$link->close();
*/		
	}else{
		$link=Conectarse();
		$bdCot=$link->query("SELECT * FROM equipos Where nSerie = '".$nSerie."'");
		if($rowCot=mysqli_fetch_array($bdCot)){
			$nomEquipo			= $rowCot['nomEquipo'];
			$lugar				= $rowCot['lugar'];
			$tipoEquipo			= $rowCot['tipoEquipo'];
			
			$necesitaCal		= $rowCot['necesitaCal'];
			$fechaCal			= $rowCot['fechaCal'];
			$tpoProxCal			= $rowCot['tpoProxCal'];
			$tpoAvisoCal		= $rowCot['tpoAvisoCal'];
			$fechaProxCal		= $rowCot['fechaProxCal'];

			$necesitaVer		= $rowCot['necesitaVer'];
			$fechaVer			= $rowCot['fechaVer'];
			$tpoProxVer			= $rowCot['tpoProxVer'];
			$tpoAvisoVer		= $rowCot['tpoAvisoVer'];
			$fechaProxVer		= $rowCot['fechaProxVer'];

			$necesitaMan		= $rowCot['necesitaMan'];
			$fechaMan			= $rowCot['fechaMan'];
			$tpoProxMan			= $rowCot['tpoProxMan'];
			$tpoAvisoMan		= $rowCot['tpoAvisoMan'];
			$fechaProxMan		= $rowCot['fechaProxMan'];
			
			$usrResponsable		= $rowCot['usrResponsable'];
			
			$Referencia			= $rowCot['Referencia'];
			$FormularioCal		= $rowCot['FormularioCal'];
			$FormularioVer		= $rowCot['FormularioVer'];
			$FormularioMan		= $rowCot['FormularioMan'];
		}
		$link->close();
		$encNew = 'No';
	}
?>

<style>
/*body {overflow-y:hidden;}*/
</style>
<script language="javascript">
	document.getElementById("Cuerpo").style.visibility="hidden";
	document.getElementById("cajaRegistraPruebas").style.visibility="visible";
</script>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">
		<center>
		<form name="form" action="plataformaEquipos.php" method="post">
			<table width="99%"  border="0" cellpadding="0" cellspacing="0" id="tablaDatosAjax">
				<tr>
					<td colspan="3" bgcolor="#0099CC" style="color:#FFFFFF; font-size:18px; ">
						<img src="../imagenes/about_us_close_128.png" width="50" align="middle">
						<span style="color:#FFFFFF; font-size:25px; font-weight:700;">
							Equipamiento - Instrumentos
							<div id="botonImagen">
								<?php 
									if($accion=='Vacio'){
										$prgLink = '../plataformaErp.php';
										$accion = 'Agrega';
									}else{
										$prgLink = 'plataformaEquipos.php';
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
							CÃ³d.Equipos NÂ°  
							<?php
								if($accion == 'Actualizar' or $accion == 'Borrar' or $accion == 'AgrForm'){ 
									echo $nSerie;?>
									<input name="nSerie" 	id="nSerie" type="hidden" value="<?php echo $nSerie; ?>" size="7" maxlength="7" style="font-size:18px; font-weight:700;" />
									<?php
								}
								if($accion == 'Agrega'){ 
									?>
									<input name="nSerie" 	id="nSerie" type="text" value="<?php echo $nSerie; ?>" size="20" maxlength="20" style="font-size:18px; font-weight:700;" autofocus />
									<?php
								}
							?>
							<input name="accion" 				id="accion" 			type="hidden" value="<?php echo $accion; ?>">
						</strong>										
					</td>
			  	</tr>
				<tr>
					<td width="19%">Id.Equipo / Instrumento </td>
					<td class="lineaDer">Tipo				</td>
					<td class="lineaDer">Responzable Equipo	</td>
				  </tr>
				<tr>
					<td rowspan="3" class="lineaDerBot">
						<textarea name="nomEquipo" id="nomEquipo" cols="50" rows="5"><?php echo $nomEquipo; ?></textarea>
					</td>
					<td valign="top" class="lineaDerBot">
						<select name="tipoEquipo" id="tipoEquipo" style="font-size:12px; font-weight:700;">
							<option></option>
							<?php if($tipoEquipo=='E') {?>
								<option selected>Equipo</option>
							<?php }else{ ?>
								<option>Equipo</option>
							<?php } ?>
							<?php if($tipoEquipo=='I') {?>
								<option selected>Instrumento</option>
							<?php }else{ ?>
								<option>Instrumento</option>
							<?php } ?>
						</select>
				  	</td>
				    <td valign="top" class="lineaDerBot">
						<select name="usrResponsable" id="usrResponsable" style="font-size:12px; font-weight:700;">
							<option></option>
						  <?php
								$link=Conectarse();
								$bdCli=$link->query("SELECT * FROM Usuarios Order By usuario");
								if($rowCli=mysqli_fetch_array($bdCli)){
									do{
										$loginRes = $rowCli['usr'];
										if($usrResponsable == $loginRes){
											echo '<option selected 	value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}else{
											echo '<option 			value='.$rowCli['usr'].'>'.$rowCli['usuario'].'</option>';
										}
									}while ($rowCli=mysqli_fetch_array($bdCli));
								}
								$link->close();
								?>
						</select>		        
					</td>
		      	</tr>
				<tr>
				  <td colspan="2" valign="top" class="lineaDerBot">Ubicaci&oacute;n</td>
				</tr>
				<tr>
				  <td colspan="2" valign="top" class="lineaDerBot">
				  	<input name='lugar' id="lugar" size="50" maxlength="50" value="<?php echo $lugar; ?>">
				  </td>
				</tr>
				<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
					<td colspan="6">
						POC 
					</td>
				</tr>
				<tr>
					<td>
						<select name="Referencia" id="Referencia" style="font-size:12px; font-weight:700;">
							<option></option>
						  <?php
								$link=Conectarse();
								$bdAc=$link->query("SELECT * FROM Documentacion Order By nDocGes");
								if($rowAc=mysqli_fetch_array($bdAc)){
									do{
										if($Referencia == $rowAc['Referencia']){
											echo '<option selected 	value='.$rowAc['Referencia'].'>'.$rowAc['Referencia'].'</option>';
										}else{
											echo '<option 			value='.$rowAc['Referencia'].'>'.$rowAc['Referencia'].'</option>';
										}
									}while ($rowAc=mysqli_fetch_array($bdAc));
								}
								$link->close();
								?>
						</select>		        
					</td>
				</tr>
				<tr>
			  	<td colspan="3" class="lineaDerBot">
			  		
					<table cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #000;">
						<tr height="30" bgcolor="#0099CC" style="color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px; font-weight:700;">
							<td colspan="6">
								Acciones Necesarias 
							</td>
						</tr>
						<tr>
							<td class="lineaDerBot">Acci&oacute;n</td>
							<td class="lineaDerBot">Necesaria / Form.</td>
							<td class="lineaDerBot">Fecha &Uacute;ltima </td>
							<td class="lineaDerBot">Pr&oacute;xima  (D&iacute;as) </td>
							<td class="lineaDerBot">Avisar (D&iacute;as) </td>
							<td class="lineaDerBot">Fecha Pr&oacute;xima</td>
				      	</tr>
						<tr>
						  	<td class="lineaDerBot">Calibraci&oacute;n</td>
						  	<td class="lineaDerBot">
								<?php
								if($necesitaCal=='on'){?>
									<input type="checkbox" name="necesitaCal" id="necesitaCal" checked>
								<?php }else{ ?>
									<input type="checkbox" name="necesitaCal" id="necesitaCal">
								<?php } ?>
								<?php
								if($nSerie){
									$link=Conectarse();
									$sql = "SELECT * FROM equiposForm Where nSerie = '".$nSerie."' and AccionEquipo = 'Cal'";
									$bdEnc=$link->query($sql);
									if($row=mysqli_fetch_array($bdEnc)){
										do{
											echo '<br>Form: '.$row['Formulario'];?>
											<a href="plataformaEquipos.php?nSerie=<?php echo $nSerie; ?>&accion=Actualizar&borraFormulario=<?php echo $row['Formulario']; ?>&AccionEquipo=Cal"><img src="../imagenes/error.png" width="16"></a>
											<?php
										}while ($row=mysqli_fetch_array($bdEnc));
									}
									$link->close();
								}
								?>
								<br>
								<input name="FormularioCal" id="FormularioCal" type="text" size="5" list="formularios">
								<datalist id="formularios">
										<?php
											$link=Conectarse();
											$bdProv=$link->query("SELECT * FROM docFormPOC");
											if($row=mysqli_fetch_array($bdProv)){
												do{?>
													<option value="<?php echo $row['Formulario']; ?>">
													<?php
												}while ($row=mysqli_fetch_array($bdProv));
											}
										?>
								</datalist>
								<button name="guardarEquipoSeguir">
									<img src="../imagenes/add_32.png" width="16">
								</button>
								
							</td>
						  	<td class="lineaDerBot">
						    	<input name="fechaCal" id="fechaCal" type="date" value="<?php echo $fechaCal; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
						  	<td class="lineaDerBot">
						    	<input name="tpoProxCal" id="tpoProxCal" type="text" size="3" maxlength="3" value="<?php echo $tpoProxCal; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
						  	<td class="lineaDerBot"><input name="tpoAvisoCal" id="tpoAvisoCal" type="text" size="3" maxlength="3" value="<?php echo $tpoAvisoCal; ?>" style="font-size:12px; font-weight:700;" /></td>
						  	<td class="lineaDerBot">
								<script>
									//$("#fechaProxCal").hide();
								</script>
						    	<input name="fechaProxCal" id="fechaProxCal" type="date" value="<?php echo $fechaProxCal; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
					 	</tr>
						<tr>
							<td class="lineaDerBot">Verificaci&oacute;n</td>
						  	<td class="lineaDerBot"><?php
								if($necesitaVer=='on'){?>
									<input name="necesitaVer" type="checkbox" id="necesitaVer" checked>
								<?php }else{ ?>
									<input name="necesitaVer" type="checkbox" id="necesitaVer">
								<?php } ?>
								<?php
								if($nSerie){
									$link=Conectarse();
									$sql = "SELECT * FROM equiposForm Where nSerie = '".$nSerie."' and AccionEquipo = 'Ver'";
									$bdEnc=$link->query($sql);
									if($row=mysqli_fetch_array($bdEnc)){
										do{
											echo '<br>Form: '.$row['Formulario'];?>
											<a href="plataformaEquipos.php?nSerie=<?php echo $nSerie; ?>&accion=Actualizar&borraFormulario=<?php echo $row['Formulario']; ?>&AccionEquipo=Ver"><img src="../imagenes/error.png" width="16"></a>
											<?php
										}while ($row=mysqli_fetch_array($bdEnc));
									}
									$link->close();
								}
								?>
								<br>
								<input name="FormularioVer" id="FormularioVer" type="text" size="5" list="formularios">
								<datalist id="formularios">
										<?php
											$link=Conectarse();
											$bdProv=$link->query("SELECT * FROM docFormPOC");
											if($row=mysqli_fetch_array($bdProv)){
												do{?>
													<option value="<?php echo $row['Formulario']; ?>">
													<?php
												}while ($row=mysqli_fetch_array($bdProv));
											}
										?>
								</datalist>
								<button name="guardarEquipoSeguir">
									<img src="../imagenes/add_32.png" width="16">
								</button>
								
							</td>
						  	<td class="lineaDerBot">
						    	<input name="fechaVer" id="fechaVer" type="date" value="<?php echo $fechaVer; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						  	<td class="lineaDerBot">
						    	<input name="tpoProxVer" id="tpoProxVer" type="text" size="3" maxlength="3" value="<?php echo $tpoProxVer; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
						  	<td class="lineaDerBot">
								<input name="tpoAvisoVer" id="tpoAvisoVer" type="text" size="3" maxlength="3" value="<?php echo $tpoAvisoVer; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						  	<td class="lineaDerBot">
						    	<input name="fechaProxVer" id="fechaProxVer" type="date" value="<?php echo $fechaProxVer; ?>" style="font-size:12px; font-weight:700;" />
						  	</td>
					  	</tr>
						<tr>
							<td class="lineaDerBot">
								Mantenci&oacute;n
							</td>
						    <td class="lineaDerBot">
								<?php
								if($necesitaMan=='on'){?>
									<input name="necesitaMan" type="checkbox" id="necesitaMan" checked>
								<?php }else{ ?>
									<input name="necesitaMan" type="checkbox" id="necesitaMan">
								<?php } ?>
								<?php
								if($nSerie){
									$link=Conectarse();
									$sql = "SELECT * FROM equiposForm Where nSerie = '".$nSerie."' and AccionEquipo = 'Man'";
									$bdEnc=$link->query($sql);
									if($row=mysqli_fetch_array($bdEnc)){
										do{
											echo '<br>Form: '.$row['Formulario'];?>
											<a href="plataformaEquipos.php?nSerie=<?php echo $nSerie; ?>&accion=Actualizar&borraFormulario=<?php echo $row['Formulario']; ?>&AccionEquipo=Man"><img src="../imagenes/error.png" width="16"></a>
											<?php
										}while ($row=mysqli_fetch_array($bdEnc));
									}
									$link->close();
								}
								?>
								<br>
								<input name="FormularioMan" id="FormularioMan" type="text" size="5" list="formularios">
								<datalist id="formularios">
										<?php
											$link=Conectarse();
											$bdProv=$link->query("SELECT * FROM docFormPOC");
											if($row=mysqli_fetch_array($bdProv)){
												do{?>
													<option value="<?php echo $row['Formulario']; ?>">
													<?php
												}while ($row=mysqli_fetch_array($bdProv));
											}
										?>
								</datalist>
								<button name="guardarEquipoSeguir">
									<img src="../imagenes/add_32.png" width="16">
								</button>
								
							</td>
						    <td class="lineaDerBot">
						      	<input name="fechaMan" id="fechaMan" type="date" value="<?php echo $fechaMan; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						    <td class="lineaDerBot">
						      <input name="tpoProxMan" id="tpoProxMan" type="text" size="3" maxlength="3" value="<?php echo $tpoProxMan; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						    <td class="lineaDerBot">
								<input name="tpoAvisoMan" id="tpoAvisoMan" type="text" size="3" maxlength="3" value="<?php echo $tpoAvisoMan; ?>" style="font-size:12px; font-weight:700;" />
							</td>
						    <td class="lineaDerBot">
						      <input name="fechaProxMan" id="fechaProxMan" type="date" value="<?php echo $fechaProxMan; ?>" style="font-size:12px; font-weight:700;" />
							</td>
					    </tr>

					</table>
			  </td>
		  </tr>
		  <tr>
				<td colspan="3" bgcolor="#FFFFFF" style="color:#666666; border-top:1px solid; font-size:18px; ">
					<?php
						echo $accion;
						if($accion == 'Guardar' or $accion == 'Agrega' or $accion == 'Actualizar' or $accion == 'AgrForm'){?>
							<div id="botonImagen">
								<button name="guardarEquipo" style="float:right;" title="Guardar Datos Equipo">
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
