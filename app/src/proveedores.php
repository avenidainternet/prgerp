	<div class="row bg-info text-white" style="padding: 10px;"  ng-show="tTablaDetalle">
			<div class="col-1">
				Proveedor
			</div>
			<div class="col-8">
				<input class="form-control uppercase" ng-change="loadProveedores()" ng-model="bProveedor" type="text" size="12" maxlength="12" >
			</div>
			<div class="col-3">
				<button type="button" class="btn btn-primary" ng-click="agregarProveedor()">
 	 				+ Agregar Proveedor
				</button>
			</div>	

	</div>

	
	<div class="container-fluid" style="margin-top: 10px;"  ng-show="tTablaDetalle">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
		<table class="table table-hover table-bordered" ng-show="tCertificados">
	    	<thead>
				<tr class="bg-dark text-light">
			        <th>RUT 					</th>
			        <th>Proveedores 			</th>
			        <th>Contacto 				</th>
			        <th>Teléfono 				</th>
			        <th>Producto o Servicio		</th>
			        <th>Acciones				</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in dataProveedores | filter : bProveedor" 
	      			ng-class="{'default-color': x.RutProv != '', 'pasivo-class': x.RutProv == ''}">
			        <td><b>{{x.RutProv}}			</b></td>
			        <td><b>{{x.Proveedor}}			</b></td>
			        <td><b>{{x.Contacto}}			</b></td>
			        <td><b>{{x.Telefono}}			</b></td>
			        <td><b>{{x.productoServicio}}	</b></td>
			        <td>
						<button type="button" class="btn btn-warning" ng-click="editarProveedor(x.RutProv)">Editar</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  	</table>
	</div>

	<!-- The Modal -->
<div class="container">
	<div class="card m-2" ng-show="registroDatos">
    	<div class="card-header">
			<h4>{{proceso}} Proveedor</h4>
		</div>
    	<div class="card-body">
			<div class="row m-2">
				<div class="col-sm-2">
					RUT :
				</div>
				<div class="col-sm-2">
					<div ng-show="nuevoProveedor">
						<input type="text" class="form-control" id="RutProv" ng-model="RutProv" maxlength="13">
					</div>
					<div ng-show="antiguoProveedor">
  						<h4>{{RutProv}}</h4>
					</div>
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Proveedor:
				</div>
				<div class="col-sm-10">
  					<input type="text" class="form-control" id="Proveedor" ng-model="Proveedor">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Productos o Servicios:
				</div>
				<div class="col-sm-10">
  					<input type="text" class="form-control" id="productoServicio" ng-model="productoServicio">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Tipo Documento que Emite:
				</div>
				<div class="col-sm-10">
  					<input type="text" class="form-control" id="tpDocumentoEmite" ng-model="tpDocumentoEmite">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Dirección:
				</div>
				<div class="col-sm-10">
  					<input type="text" class="form-control" id="Direccion" ng-model="Direccion">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Contacto:
				</div>
				<div class="col-sm-10">
  					<input type="text" class="form-control" id="Contacto" ng-model="Contacto">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Correo:
				</div>
				<div class="col-sm-10">
  					<input type="text" class="form-control" id="Email" ng-model="Email">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Teléfono:
				</div>
				<div class="col-sm-4">
  					<input type="text" class="form-control" id="Teléfono" ng-model="Telefono">
				</div>
				<div class="col-sm-2">
					Celular:
				</div>
				<div class="col-sm-4">
  					<input type="text" class="form-control" id="Celular" ng-model="Celular">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Banco:
				</div>
				<div class="col-sm-3">
  					<input type="text" class="form-control" id="Banco" ng-model="Banco">
				</div>
				<div class="col-sm-1">
					Tp.Cta:
				</div>
				<div class="col-sm-2">
  					<input type="text" class="form-control" id="TpCta" ng-model="TpCta">
				</div>
				<div class="col-sm-2">
					Núm.Cta:
				</div>
				<div class="col-sm-2">
  					<input type="text" class="form-control" id="NumCta" ng-model="NumCta">
				</div>
			</div>
		</div>
    	<div class="card-footer">
			<button type="button" class="btn btn-primary" ng-click="grabarProveedor()">Guardar</button>
		</div>
	</div>
</div>