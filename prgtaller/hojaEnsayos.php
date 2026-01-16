<style>
	#tituloSolicitud {
		width			: 100%;
		border-bottom	: 2px solid #000;
		border-top		: 2px solid #000;
		text-align		: center;
		background-color: LightGray;
	}
	#tituloSolicitud tit{
		color			: #000;
		font-family		: Arial;
		font-size		: 40px;
	}
	#formatoEnsayos {
		font-family		: Arial;
		font-weight		: bold;
		padding			: 10px;
		font-size		: 16px;
	}
	#formatoEnsayos .lineaSeparador {
		border-bottom	: 1px solid #000;
		padding-bottom	: 10px;
	}
	#formatoEnsayos .lineaSeparador.izq {
		float			: right;
	}
	
</style>
<div id="bloqueoTrasperente">
	<div id="cajaRegistraPruebas">

<div id="tablaDatosAjax">
	<div id="tituloSolicitud">
		<tit>Solicitud Servicio de Taller</tit>
	</div>
	<div id="formatoEnsayos">
		<div class="lineaSeparador">
			<?php
				$link=Conectarse();
				$SQL = "Select * From cotizaciones Where RAM = $RAM";
				//echo $SQL;
				$bdCot=mysql_query($SQL);
				if($rowCot=mysql_fetch_array($bdCot)){?>
					RAM: <?php echo $RAM; ?>
					<span style="float: right;">Fecha Programación : <input name="fechaTaller" type="date" value="<?php echo $rowCot['fechaInicio']; ?>"></span>
				<?php
				}
				mysql_close($link);
				?>
		</div>
	</div>
</div>
</div>
</div>