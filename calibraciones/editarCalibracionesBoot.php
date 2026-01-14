	<div class="alert alert-success alert-dismissible" ng-show="msgGraba">
		<strong>{{datResp}}!</strong>
	</div>

	<table class="table table-striped text-center">
		<thead>
			<tr>
				<th>Ensayo				</td>
				<th>Equipo				</th>
				<th>A 					</th>
				<th>B					</th>
				<th>Punto Equilibrio	</th>
				<th>C					</th>
				<th>D					</th>
				<th>Acción				</th>
			</tr>
		</thead>
		<tbody>
			<!-- <tr>
				<td>Charpy</td>
				<td><input ng-model="Equipo" 		size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="calA" 			size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="calB" 			size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="EquilibrioX" 	size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="calC" 			size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="calD" 			size="6" maxlength="6" class="form-control" required /></td>
				<td>
					<button ng-click="guardar()" type="button" class="btn btn-primary">
						Guardar
					</button>

				</td>
			</tr> -->
			<tr>
				<td colspan=4>Formula Charpy: Y = ax + b</td>
				<td colspan=3>Formula Charpy C/Entalle: Y = cx + d</td>
			</tr>
			<tr ng-repeat="x in dataCal">
				<td>Charpy</td>
				<td>{{x.Equipo}}</td>
				<td><input ng-model="x.calA" 			size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="x.calB" 			size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="x.EquilibrioX" 	size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="x.calC" 			size="6" maxlength="6" class="form-control" required /></td>
				<td><input ng-model="x.calD" 			size="6" maxlength="6" class="form-control" required /></td>
				<td>
					<button ng-click="guardarX(x.Equipo, x.calA, x.calB, x.EquilibrioX, x.calC, x.calD)" type="button" class="btn btn-primary">
						Guardar
					</button>
				</td>

			</tr>
		</tbody>
	</table>
