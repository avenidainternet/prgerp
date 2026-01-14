<div class="row bg-info text-white" style="padding: 10px;" ng-init="cargarDependencias()" ng-show="tablaDependencias">
	<div class="col-1">
		Dependencia
	</div>
	<div class="col-8">
		<input class="form-control uppercase" ng-change="loadDependencia()" ng-model="bDependencia" type="text" size="12" maxlength="12" >
	</div>
	<div class="col-3">
		<button type="button" class="btn btn-primary" ng-click="agregarDependencia()">
 	 		+ Agregar Dependencia
		</button>
	</div>	
</div>

	<div class="container-fluid" style="margin-top: 10px;"  ng-show="tablaDependencias">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
	  	<table class="table table-hover table-bordered" ng-show="tCertificados">
	    	<thead>
				<tr class="bg-dark text-light">
			        <th># 				</th>
			        <th>Dependencias 	</th>
			        <th>Responsable 	</th>
			        <th>Acciones		</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in dataDependencias | filter : bDependencia" 
	      			ng-class="{'default-color': x.usrResponsable != '', 'pasivo-class': x.usrResponsable == ''}">
			        <td>{{x.nDependencia}}		</td>
			        <td>{{x.Dependencia}}		</td>
			        <td>{{x.usrResponsable}}	</td>
			        <td>
			        	<!-- <a 	class="btn btn-warning" role="button" href="../certproductos?CodCertificado={{x.ar}}">Editar</a> -->
						<button type="button" class="btn btn-warning" ng-click="editarDependencia(x.nDependencia)">Editar</button>
	        		</td>
	      		</tr>
	    	</tbody>
	  	</table>
	</div>

<!-- The Modal -->
<div class="container">
	<div class="card m-2" ng-show="regDependencia">
    	<div class="card-header">
			<h4>Agregar Dependencia</h4>
		</div>
    	<div class="card-body">
			<div class="row m-2">
				<div class="col-sm-2">
					Id Dependencia:
				</div>
				<div class="col-sm-1">
  					<h4>{{nDependencia}}</h4>
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Dependencia:
				</div>
				<div class="col-sm-8">
  					<input type="text" class="form-control" id="Dependencia" ng-model="Dependencia">
				</div>
			</div>
			<div class="row m-2">
				<div class="col-sm-2">
					Responsable:
				</div>
				<div class="col-sm-2">
  					<input type="text" class="form-control" id="usrResponsable" ng-model="usrResponsable">
				</div>
			</div>
		</div>
    	<div class="card-footer">
			<button type="button" class="btn btn-primary" ng-click="grabarDependencia()">Guardar</button>
		</div>
	</div>
</div>