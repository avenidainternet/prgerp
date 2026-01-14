<div class="row bg-info text-white" style="padding: 10px;" ng-show="tTablaDetalle">
			<div class="col-1">
				Unidad de Medida
			</div>
			<div class="col-5">
				<input class="form-control uppercase" ng-change="loadUnidadMedida()" ng-model="bUnidad" type="text" size="12" maxlength="12" >
			</div>
			<div class="col-3">
				<button type="button" class="btn btn-primary" ng-click="agregarUnidadMedida()">
 	 				+ Agregar Unidad de Medida
				</button>
			</div>	

	</div>

	
	<div class="container" style="margin-top: 10px;" ng-show="tTablaDetalle">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
		<table class="table table-hover table-bordered">
	    	<thead>
				<tr class="bg-dark text-light">
			        <th># 					</th>
			        <th>Id.Unidad 			</th>
			        <th>Unidad de Medida 	</th>
			        <th>Acciones			</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in dataUnidadMedida | filter : bUnidad" 
	      			ng-class="{'default-color': x.idUnidad != '', 'pasivo-class': x.idUnidad == ''}">
			        <td><b>{{x.nUnidad}}	</b></td>
			        <td><b>{{x.idUnidad}}	</b></td>
			        <td><b>{{x.Unidad}}		</b></td>
			        <td>
						<button type="button" class="btn btn-warning" ng-click="editarUnidadMedida(x.nUnidad)">Editar</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  	</table>
	</div>

	<!-- The Modal -->
<div class="container">
	<div class="card m-2" ng-show="registroDatos">
    	<div class="card-header">
			<h4>Agregar Unidad de Medida</h4>
		</div>
    	<div class="card-body">
			<div class="row m-2">
				<div class="col-sm-2">
					N° Unidad:
				</div>
				<div class="col-sm-1">
  					<h4>{{nUnidad}}</h4>
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Id Unidad:
				</div>
				<div class="col-sm-2">
  					<input type="text" class="form-control" id="idUnidad" ng-model="idUnidad">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Descripción Unidad:
				</div>
				<div class="col-sm-2">
  					<input type="text" class="form-control" id="Unidad" ng-model="Unidad">
				</div>
			</div>
		</div>
    	<div class="card-footer">
			<button type="button" class="btn btn-primary" ng-click="grabarUnidadMedida()">Guardar</button>
		</div>
	</div>
</div>