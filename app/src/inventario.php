<div class="row bg-primary text-white" ng-show="tTablaDetalle" ng-init="loadInventario()">
	<div class="col">
		<div class="btn-group">
			<a  class="btn btn-primary" href="../../adquisiciones/itemarticulos/" title="Items Inventario"> Clasificacion</a>

			<button type="button" class="btn btn-danger">Críticos</button>
			<button type="button" class="btn btn-warning">Solicitar</button>
			<button type="button" class="btn btn-primary">+ Registrar</button>
		</div>
	</div>
</div>

<div class="row bg-info text-white" style="padding: 10px;" ng-show="tTablaDetalle">
			<div class="col-1">
				Artículo
			</div>
			<div class="col-8">
				<input class="form-control uppercase" ng-change="loadInventario()" ng-model="bInventario" type="text" size="12" maxlength="12" >
			</div>
			<div class="col-1">
				<button type="button" class="btn btn-primary" ng-click="agregarArticulo()">
 	 				+ Artículo
				</button>
			</div>	
			<div class="col-1">
				<button type="button" class="btn btn-warning" ng-click="agregarItemsInventario()">
 	 				Entrada
				</button>
			</div>	
			<div class="col-1">
				<button type="button" class="btn btn-danger" ng-click="agregarItemsInventario()">
 	 				Salida
				</button>
			</div>	

	</div>

	
	<div class="container-fluid" style="margin-top: 10px;" ng-show="tTablaDetalle">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
		<table class="table table-hover table-bordered">
	    	<thead>
				<tr class="bg-dark text-light">
			        <th># 		</th>
			        <th>Artículos 		</th>
			        <th>Cód.Barra 		</th>
			        <th>Ubicación 		</th>
			        <th>Stock Actual 	</th>
			        <th>Stock Crítico 	</th>
			        <th>Acciones		</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
				<!-- ng-class="verColorLineaServicios(x.stockCritico, x.stockActual)"> -->
				<tr ng-repeat="x in dataInventario | filter : bInventario" 
	      			ng-class="{'default-color': x.stockCritico > x.stockActual, 'pasivo-class': x.stockCritico <= x.stockActual}">
			        <td><b>{{x.nArticulo}}		</b></td>
			        <td><b>{{x.Articulo}}		</b></td>
			        <td><b>{{x.Serial}}			</b></td>
			        <td>
						<b>
							{{x.Dependencia}}	
						</b>
					</td>
			        <td><b>{{x.stockActual}}	</b></td>
			        <td><b>{{x.stockCritico}}	</b></td>
			        <td>
			        	<!-- <a 	class="btn btn-warning" role="button" href="../certproductos?CodCertificado={{x.ar}}">Editar</a> -->
						<button type="button" class="btn btn-warning" ng-click="editarInventario(x.nArticulo)">Editar</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  	</table>
	</div>


		<!-- The Modal -->
<div class="container">
	<div class="card m-2" ng-show="registroDatos">
    	<div class="card-header">
			<h4>Artículos</h4>
		</div>
    	<div class="card-body">
			<div class="row m-2">
				<div class="col-sm-1">
					N° Art.:
				</div>
				<div class="col-sm-1">
  					<h4>{{nArticulo}}</h4>
				</div>
				<div class="col-sm-1"> 
					Artículo:
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="Articulo" ng-model="Articulo">
				</div>
				<div class="col-sm-1"> 
					Cód.Barra:
				</div>
				<div class="col-sm-4">
  					<input type="text" class="form-control" id="Serial" ng-model="Serial">
				</div>
			</div>

			<div class="row m-2">
				<div class="col-sm-2">
					Clasificación:
				</div>
				<div class="col-sm-5">
					<select class="form-control" id="nItem" ng-model="nItem" ng-init="loadClasificacion()">
                        <option value=""></option>
                        <option ng-repeat="x in dataItemsInventario" value="{{x.nItem}}">{{x.Items}}</option>
                    </select>
				</div>
				<div class="col-sm-1"> 
					Ubicación:
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="idDependencia" ng-model="idDependencia" ng-init="cargarDependencias()">
                        <option value=""></option>
                        <option ng-repeat="x in dataDependencias" value="{{x.nDependencia}}">{{x.Dependencia}}</option>
                    </select>
				</div>
			</div>
			<hr>

			<div class="row m-2 text-center">
				<div class="col-sm-2"> 
					<div class="form-group">
						<label for="Plano">Un.Medida:</label>
						<select class="form-control m-2" id="nUnidad" ng-model="nUnidad" ng-init="loadUnidadMedida()">
                        	<option value=""></option>
                        	<option ng-repeat="x in dataUnidadMedida" value="{{x.idUnidad}}">{{x.Unidad}}</option>
                    	</select>
					</div>
				</div>
				<div class="col-sm-2"> 
					<div class="form-group">
						<label for="Plano">Cantidad X Unidad</label>
  						<input type="text" class="form-control m-2" id="cantidadXUnidad" ng-model="cantidadXUnidad">
					</div>
				</div>
				<div class="col-sm-2"> 
					<div class="form-group">
						<label for="Plano">Unidades</label>
  						<input type="text" class="form-control m-2" id="nUnidades"  ng-model="nUnidades" >
					</div>
				</div>
				<div class="col-sm-2"> 
					<div class="form-group">
						<label for="Plano">Stock</label>
  						<input type="text" class="form-control m-2" id="Stock"  ng-model="Stock" readonly >
					</div>
				</div>
				<div class="col-sm-2"> 
					<div class="form-group">
						<label for="Plano">Salida</label>
  						<input type="text" class="form-control m-2" id="Salida"  ng-model="Salida" readonly >
					</div>
				</div>
				<div class="col-sm-1"> 
					<div class="form-group">
						<label for="Plano">Actual</label>
  						<input type="text" class="form-control m-2" id="stockActual"  ng-model="stockActual" readonly >
					</div>
				</div>
				<div class="col-sm-1"> 
					<div class="form-group">
						<label for="Plano">Crítico</label>
  						<input type="text" class="form-control m-2" id="stockCritico"  ng-model="stockCritico" >
					</div>
				</div>
			</div>
		</div>
    	<div class="card-footer">
			<button type="button" class="btn btn-primary" ng-click="grabarArticulo()">Guardar</button>
		</div>
	</div>
</div>
