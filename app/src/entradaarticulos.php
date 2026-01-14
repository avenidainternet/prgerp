<div class="row bg-info text-white" style="padding: 10px;">
			<div class="col-1">
				Artículo
			</div>
			<div class="col-5">
				<input class="form-control uppercase" ng-change="loadClientes()" ng-model="bCertificado" type="text" size="12" maxlength="12" >
			</div>
	</div>

	
	<div class="container" style="margin-top: 10px;">
		<div class="spinner-border" ng-show="loading">Cargando...</div>
	  	<table class="table table-dark table-hover table-bordered" ng-show="tCertificados">
	    	<thead>
	      		<tr>
			        <th># 					</th>
			        <th>Id.Unidad 			</th>
			        <th>Unidad de Medida 	</th>
			        <th>Acciones			</th>
	      		</tr>
	    	</thead>
	    	<tbody> 
	      		<tr ng-repeat="x in Certificados | filter : bCertificado" 
	      			ng-class="{'default-color': x.pdf != '', 'pasivo-class': x.pdf == ''}">
			        <td><b>{{x.ar}}</b></td>
			        <td><b>{{x.Cliente}}</b></td>
			        <td><b>{{x.Cliente}}</b></td>
			        <td><b>{{x.nColadas}}</b></td>
			        <td>
			        	<!-- <a 	class="btn btn-warning" role="button" href="../certproductos?CodCertificado={{x.ar}}">Editar</a> -->
			        	<a 	class="btn btn-warning" role="button" href="../certMAr/?ar={{x.ar}}">Editar</a>
	        		</td>
	      		</tr>
	    	</tbody>
	  	</table>
	</div>
