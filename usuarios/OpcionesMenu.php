<?php
	include_once("../conexionli.php");
	$nMenu 		= 1;
	$nModulo 	= 0;
	$nomMenu	= '';
	$iconoMenu	= '';
	if(isset($_GET['nMenu'])) 		{ $nMenu 	= $_GET['nMenu']; 		}
	if(isset($_GET['nModulo'])) 	{ $nModulo 	= $_GET['nModulo']; 	}
	if(isset($_GET['icnoMenu'])) 	{ $icnoMenu = $_GET['icnoMenu']; 	}
?>
<div id="EncabezadosTitulosMenuLateral" class="degradado">
	<img src="../imagenes/select_next_32.png" style="margin:2px;" align="absmiddle" width="20px">
	Configuración Menú (
		<?php
			$link=Conectarse();
			$bdMg=$link->query("SELECT * FROM menugrupos Where nMenu = $nMenu");
			if ($rowMg=mysqli_fetch_array($bdMg)){
				echo $rowMg['nomMenu'];
				$nomMenu 	= $rowMg['nomMenu'];
				$iconoMenu 	= $rowMg['iconoMenu'];
			}
		?>
	)
	
</div>
<!-- <form method="post" id="formulario" enctype="multipart/form-data"> -->
<div id="info"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:5px;" >
	<tr>
		<td width="20%" style="padding:5px;">
			Items de Grupo : 
		</td>
		<td width="80%">
			<!-- Ingreso y activa automaticamente  
				<input type="text" onkeyup="actualizaGrupo(<?php echo $nMenu; ?>, this.value)" value="<?php echo $nomMenu; ?>">
			-->
			<input name="nMenu" 	id="nMenu" 		type="hidden" value="<?php echo $nMenu; ?>">
			<input name="nomMenu" 	id="nomMenu" 	type="text" size="50" maxlength="50" value="<?php echo $nomMenu; ?>">
		</td>
	</tr>
	<tr>
		<td style="padding:5px;">
			Ícono Grupo : 
		</td>
		<td>
<!--		
			<input type="hidden" name="MAX_FILE_SIZE" value="20480000"> 
			<input name="iconoMenu" type="file" id="iconoMenu">
-->			
			<input name="iconoMenu" 	id="iconoMenu" 	type="text" size="80" maxlength="80" value="<?php echo $iconoMenu; ?>">
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<button name="guardarItem" onclick="ajax_post();">
				Guardar Items
			</button>
		</td>
	</tr>
</table>
<!-- </form> -->
<?php
if($nModulo > 0){
	$link=Conectarse();
	$bdMg=$link->query("SELECT * FROM menuItems Where nMenu = $nMenu and nModulo = $nModulo");
	if($rowMg=mysqli_fetch_array($bdMg)){?>
		<div id="infoModulo"></div>
		<div id="EncabezadosTitulosMenuLateral" class="degradado">
			<img src="../imagenes/select_next_32.png" style="margin:2px;" align="absmiddle" width="20px">
			<?php echo 'Módulos del Menú '.$nomMenu.' ( <b>'.$rowMg['titulo'].'</b> )'; ?>
		</div>	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:5px;" >
			<tr>
				<td width="20%" style="padding:5px;">
					Módulo N° : 
				</td>
				<td>
					<input name="nMenu" 	id="nMenu" 		type="hidden" value="<?php echo $nMenu; ?>">
					<input name="nModulo" 	id="nModulo" 	type="text" value="<?php echo $rowMg['nModulo']; ?>">
				</td>
			</tr>
			<tr>
				<td style="padding:5px;">
					Módulo :
				</td>
				<td style="padding:5px;">
					<input name="titulo" id="titulo" type="text" value="<?php echo $rowMg['titulo']; ?>">
				</td>
			</tr>
			<tr>
				<td style="padding:5px;">
					Link / Enlace :
				</td>
				<td style="padding:5px;">
					<input name="enlace" id="enlace" type="text" size="80" value="<?php echo $rowMg['enlace']; ?>">
				</td>
			</tr>
			<tr>
				<td style="padding:5px;">
					Ícono Módulo :
				</td>
				<td style="padding:5px;">
					<input name="iconoMod" 	id="iconoMod" 	type="text" size="80" maxlength="80" value="<?php echo $rowMg['iconoMod']; ?>">
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<button name="guardarModulo" onclick="ajax_modulo();">
						Guardar Módulo
					</button>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>
<script type="text/javascript">
	function ajax_modulo(){
		var nMenu 		= document.getElementById("nMenu").value;
		var nModulo		= document.getElementById("nModulo").value;
		var titulo 		= document.getElementById("titulo").value;
		var enlace 		= document.getElementById("enlace").value;
		var iconoMod 	= document.getElementById("iconoMod").value;
		
		var parametros = {
			"nMenu" 	: nMenu,
			"nModulo" 	: nModulo,
			"titulo" 	: titulo,
			"enlace"	: enlace,
			"iconoMod" 	: iconoMod
		};
		//alert(titulo);
		$.ajax({
			data: parametros,
			url: 'guardaMenuModulo.php',
			type: 'post',
			success: function (response) {
				$("#infoModulo").html(response);
				muestraMenu();
			}
		});
	}

	function ajax_post(){
		var nMenu 		= document.getElementById("nMenu").value;
		var nomMenu 	= document.getElementById("nomMenu").value;
		var iconoMenu 	= document.getElementById("iconoMenu").value;
		
		var parametros = {
			"nMenu" 	: nMenu,
			"nomMenu" 	: nomMenu,
			"iconoMenu" : iconoMenu
		};
		//alert(iconoMenu);
		$.ajax({
			data: parametros,
			url: 'servidor.php',
			type: 'post',
			success: function (response) {
				$("#info").html(response);
				muestraMenu();
			}
		});
	}
	
	function actualizaGrupo(nMenu, nomMenu){
		alert(nMenu);
		//$("#mOpcMenu").load("OpcionesMenu.php?nMenu="+nMenu+"&nModulo="+nModulo);		
	}
</script>