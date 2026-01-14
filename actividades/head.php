<div class="container-fluid">

		<div class="row bg-secondary text-white">
			<div class="col-1">
				<img src="../imagenes/simet.png" class="p-2">
			</div>
			<div class="col-8 text-center p-2">
				<h6>Servicio de Ingeniería Metalúrgica y Materiales - ACTIVIDADES</h6>
			</div>
			<div class="col-3">
				<?php if(isset($_SESSION['usuario'])){ ?>
				<span align="right">
					<?php echo $_SESSION['usuario']; ?> <span id="hora"></span>
				</span>									
				<?php } ?>
			</div>
		</div>
</div>