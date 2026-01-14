	<div class="alert alert-success alert-dismissible" ng-show="msgGraba">
		<strong>{{datResp}}!</strong>
	</div>
	<table class="table table-striped text-center">
		<thead>
			<tr>
				<th>Símbolo</td>
				<th>Valor Estandard</th>
				<th>Imprimible</th>
				<th>Acción</th>
			</tr>
		</thead>
			<tr ng-repeat="reg in namesCo" class="odd gradeX">
				<td>
					<input ng-model="reg.Simbolo" 	size="2" maxlength="2" class="form-control" required />
				</td>
				<td>
					<input ng-model="reg.valorDefecto" 	size="9" maxlength="9" class="form-control" required />
				</td>
				<td>
				
					<button ng-click="estadoOnOff(reg.idEnsayo, reg.tpMuestra, reg.Simbolo, reg.valorDefecto, reg.imprimible)" type="button" class="btn btn-primary">
						{{reg.imprimible}}
					</button>
				</td>
				<td>
					<button ng-click="guardarQu(reg.idEnsayo, reg.tpMuestra, reg.Simbolo, reg.valorDefecto, 'A')" type="button" class="btn btn-primary">
						Actualizar
					</button>
				</td>
			</tr>
	</table>
