	<div class="row bg-primary text-white" ng-show="tTablaDetalle">
		<div class="col">
			<div class="btn-group">
				<a  class="btn btn-primary" href="../../adquisiciones/inventario/" title="Items Inventario"> Inventario</a>
				<button type="button" class="btn btn-primary" ng-click="agregarClasificacion()">+ Clasificación</button>
			</div>
		</div>
	</div>

	<div class="row bg-info text-white" style="padding: 10px;" ng-show="tTablaDetalle">
			<div class="col-1">
				Clasificación
			</div>
			<div class="col-7">
				<input class="form-control uppercase" ng-change="loadClasificacion()" ng-model="bUnidad" type="text" size="12" maxlength="12" >
			</div>

	</div>

	
	<div class="container" style="margin-top: 10px;" ng-show="tTablaDetalle">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
		<table class="table table-hover table-bordered">
	    	<thead>
				<tr class="bg-dark text-light">
			        <th># 					</th>
			        <th>Items Inventario 			</th>
			        <th>Acciones			</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in dataItemsInventario | filter : bUnidad" 
	      			ng-class="{'default-color': x.Items != '', 'pasivo-class': x.Items == ''}">
			        <td><b>{{x.nItem}}	</b></td>
			        <td><b>{{x.Items}}	</b></td>
			        <td>
						<button type="button" class="btn btn-warning" ng-click="editarClasificacion(x.nItem)">Editar</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  	</table>
	</div>

	<!-- The Modal -->
<div class="container">
	<div class="card m-2" ng-show="registroDatos">
    	<div class="card-header">
			<h4>Agregar Clasificación</h4>
		</div>
    	<div class="card-body">
			<div class="row m-2">
				<div class="col-sm-2">
					N° Items:
				</div>
				<div class="col-sm-1">
  					<h4>{{nItem}}</h4>
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Items:
				</div>
				<div class="col-sm-8">
  					<input type="text" class="form-control" id="Items" ng-model="Items">
				</div>
			</div>
		</div>
    	<div class="card-footer">
			<button type="button" class="btn btn-primary" ng-click="grabarClasificacion()">Guardar</button>
		</div>
	</div>
</div>